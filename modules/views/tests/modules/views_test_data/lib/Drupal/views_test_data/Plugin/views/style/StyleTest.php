<?php

/**
 * @file
 * Definition of Drupal\views_test_data\Plugin\views\style\StyleTest.
 */

namespace Drupal\views_test_data\Plugin\views\style;

use Drupal\Component\Annotation\Plugin;
use Drupal\Core\Annotation\Translation;
use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * Provides a general test style plugin.
 *
 * @ingroup views_style_plugins
 *
 * @Plugin(
 *   id = "test_style",
 *   title = @Translation("Test style plugin"),
 *   help = @Translation("Provides a generic style test plugin."),
 *   theme = "views_view_style_test",
 *   display_types = {"normal", "test"}
 * )
 */
class StyleTest extends StylePluginBase {

  /**
   * A string which will be output when the view is rendered.
   *
   * @var string
   */
  public $output;

  /**
   * Can the style plugin use row plugins.
   *
   * @var bool
   */
  protected $usesRowPlugin = TRUE;

  /**
   * Overrides Drupal\views\Plugin\views\style\StylePluginBase::defineOptions().
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['test_option'] = array('default' => '');

    return $options;
  }

  /**
   * Overrides Drupal\views\Plugin\views\style\StylePluginBase::buildOptionsForm().
   */
  public function buildOptionsForm(&$form, &$form_state) {
    parent::buildOptionsForm($form, $form_state);

    $form['test_option'] = array(
      '#type' => 'textfield',
      '#description' => t('This is a textfield for test_option.'),
      '#default_value' => $this->options['test_option'],
    );
  }

  /**
   * Sets the usesRowPlugin property.
   *
   * @param bool $status
   *   TRUE if this style plugin should use rows.
   */
  public function setUsesRowPlugin($status) {
    $this->usesRowPlugin = $status;
  }

  /**
   * Sets the output property.
   *
   * @param string $output
   *   The string to output by this plugin.
   */
  public function setOutput($output) {
    $this->output = $output;
  }

  /**
   * Returns the output property.
   *
   * @return string
   */
  public function getOutput() {
    return $this->output;
  }

  /**
   * Overrides Drupal\views\Plugin\views\style\StylePluginBase::render()
   */
  public function render() {
    $output = '';
    if (!$this->usesRowPlugin()) {
      $output = $this->getOutput();
    }
    else {
      foreach ($this->view->result as $index => $row) {
        $this->view->row_index = $index;
        $output .= $this->view->rowPlugin->render($row) . "\n";
      }
    }

    return $output;
  }

}
