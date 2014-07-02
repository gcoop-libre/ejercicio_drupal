<?php

/**
 * @file
 * Páginas del módulo.
 */

function ejercicio_settings_form($form, &$form_state) {
  $form['ejercicio'] = array(
    '#type' => 'fieldset',
    '#title' => t('Configuraciones de ejercicio'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['ejercicio']['ejercicio_cantidad_de_bloques'] = array(
    '#type' => 'textfield',
    '#title' => t('Cantidad de bloques'),
    '#description' => t('Cantidad de bloques a publicar'),
    '#default_value' => variable_get('ejercicio_cantidad_de_bloques', 1),
  );

  return system_settings_form($form);
}
