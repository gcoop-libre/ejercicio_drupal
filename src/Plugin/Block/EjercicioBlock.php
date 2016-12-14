<?php

namespace Drupal\ejercicio\Plugin\Block;

use Drupal\Core\Block\BlockBase;

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
  public function build() {
    // We return an empty array on purpose. The block will thus not be rendered
    // on the site. See BlockExampleTest::testBlockExampleBasic().
    return array(
      '#type' => 'markup',
      '#markup' => $this->t("Bloque Hola Mundo"),
    );
  }

}
