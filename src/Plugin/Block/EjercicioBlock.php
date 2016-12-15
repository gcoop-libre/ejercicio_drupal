<?php

namespace Drupal\ejercicio\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Provides a 'Example: empty block' block.
 *
 * @Block(
 *   id = "ejercicio_hola_mundo",
 *   admin_label = @Translation("Ejercicio: Hola Mundo")
 * )
 */
class EjercicioBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'block_ejercicio_cantidad' => 5,
    );
    return array(
      'block_ejercicio_tipo' => 5,
    );
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['block_ejercicio_cantidad'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Cantidad'),
      '#description' => $this->t('Seleccionar la cantidad de nodos a mostrar.'),
      '#size' => 4,
      '#default_value' => $this->configuration['block_ejercicio_cantidad'],
    );

    $form['block_ejercicio_tipo'] = array(
      '#type' => 'select',
      '#title' => $this->t('Tipo de contenido'),
      '#description' => $this->t('Seleccionar el tipo de contenido a mostrar.'),
      '#options' => node_type_get_names(),
      '#empty_option' => t('- Seleccionar -'),
      '#empty_value' => t('- Seleccionar -'),
      '#default_value' => $this->configuration['block_ejercicio_tipo'],
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['block_ejercicio_cantidad']
      = $form_state->getValue('block_ejercicio_cantidad');
    $this->configuration['block_ejercicio_tipo']
      = $form_state->getValue('block_ejercicio_tipo');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // We return an empty array on purpose. The block will thus not be rendered
    // on the site. See BlockExampleTest::testBlockExampleBasic().
    $tipos = node_type_get_names();
    $tipo = $this->configuration['block_ejercicio_tipo'];
    $cantidad = $this->configuration['block_ejercicio_cantidad'];
    $tipo_text = $tipo ? $tipos[$tipo] : 'No seleccionado';
    $nodos = $this->ejercicio_get_nodos($cantidad, $tipo);

    $build = [];
    $build['#theme'] = 'ejercicio_ultimos_nodos';
    $build['#cantidad'] = $cantidad;
    $build['#tipo'] = $tipo_text;
    $build['#titulos'] = $nodos;
    return $build;
  }

  public function ejercicio_get_nodos($cantidad, $tipo) {
    $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
    $query->condition('type', $tipo);
    $query->sort('created', 'DESC');
    $query->range(0, intval($cantidad));
    $nids = $query->execute();
    $nodes = \Drupal\node\Entity\Node::loadMultiple($nids); 

    foreach ($nodes as $node) {
      $url = Url::fromUri('base://node/'.$node->id());
      $link_options = array(
        'attributes' => array(
          'class' => array(
            'node-'.$node->id(),
          ),
        ),
      );
      $url->setOptions($link_options);
      $link = Link::fromTextAndUrl(t($node->getTitle()), $url )->toString();
      $links[] = $link;
    }
    return $links;
  }
}
