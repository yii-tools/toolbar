<?php

/**
 * (c) CJT TERABYTE INC
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 *        @link: https://gitlab.com/cjtterabytesoft/tadweb
 *      @author: Wilmer Arámbula <terabytefrelance@gmail.com>
 *   @copyright: (c) CJT TERABYTE INC
 *     @widgets: [ToolBar]
 *       @since: 1.0
 *         @yii: 3.0
 **/

namespace cjtterabytesoft\widgets;

use yii\base\Widget;
use yii\bootstrap4\ButtonDropdown;
use yii\helpers\Html;
use yii\helpers\Url;

class ToolBar extends Widget
{
	/**
	 * @var string the tag to use to render panel title icon
	 */
	public $_tag_icon_panel = 'i';

	/**
	 * @var string the label to use to render panel title icon
	 */
	public $_label_icon_panel = '';

	/**
	 * @var array the options to use to render panel title icons
	 */
	public $_options_icon_panel = ['class' => 'fas fa-th'];

	/**
	 * @var string the label panel title
	 */
	public $_title_panel = '';

	/**
	 * @var string the tag to use to render panel title
	 */
	public $_tag_container_panel_header = 'div';

	/**
	 * @var array the options to use to render panel title
	 */
	public $_options_container_panel_header = ['class' => 'peers bg-primary text-white align-content-center p-15'];

	/**
	 * @var string the tag to use to render panel title left
	 */
	public $_tag_left_panel_header = 'div';

	/**
	 * @var array the options to use to render panel title left
	 */
	public $_options_left_panel_header = ['class' => 'float-left'];

	/**
	 * @var string the tag to use to render panel title rigth
	 */
	public $_tag_rigth_panel_header = 'div';

	/**
	 * @var array the options to use to render panel title rigth
	 */
	public $_options_rigth_panel_header = ['class' => 'float-right ml-auto'];

	/**
	 * @var string the tag to use to render container panel button
	 */
	public $_tag_container_panel_button = 'div';

	/**
	 * @var array the options to use to render container panel button
	 */
	public $_options_container_panel_button = ['class' => 'peers bd p-15'];

	/**
	 * @var string the tag to use to render panel button left
	 */
	public $_tag_left_panel_button = 'div';

	/**
	 * @var array the options to use to render panel button left
	 */
	public $_options_left_panel_button = ['class' => 'float-left'];

	/**
	 * @var string the tag to use to render panel button rigth
	 */
	public $_tag_rigth_panel_button = 'div';

	/**
	 * @var array the options to use to render panel button rigth
	 */
	public $_options_rigth_panel_button = ['class' => 'float-right ml-auto'];

	/**
	 * @var bool whether the label should be HTML-encoded.
	 */
	public $_encodeLabel = true;

	/**
	 * @var string use to panel header title
	 */
	public $_panel_header_title = '';
	
	/**
	 * @var boolean show/hidden panel button create
	 */
	public $_button_create = true;

	/**
	 * @var boolean show/hidden panel button filter
	 */
	public $_button_filter = true;

	/**
	 * @var boolean show/hidden panel button pages
	 */
	public $_button_pages = true;

	/**
	 * @var boolean show/hidden panel button reset
	 */
	public $_button_reset = true;

	/**
	 * Initializes the widget.
	 * If you override this method, make sure you call the parent implementation first.
	 */
	public function init()
	{
		parent::init();

		$iconpanel = $this->renderIcon();
		$titlepanel = $this->renderTitlePanel();
		$this->_panel_header_title = $iconpanel . '&nbsp' . '<b>' . $titlepanel . '</b>';

		echo $this->renderPanelHeader() . $this->renderPanelBar();
	}

	private function renderButtonCreate()
	{
		$button_create = '';

		if ($this->_button_create) {
			$button_create = Html::a(
				Html::tag('i', '', ['class' => 'fas fa-plus']),
				['create'],
				['class' => 'btn btn-lg bgc-green-500 c-white', 'title' => \yii::t('toolbar', 'Add')]
			);
		}

		return $button_create;
	}

	private function renderButtonFilter()
	{
		$button_filter = '';

		if ($this->_button_filter) {
			$button_filter = Html::a(
				Html::tag('i', '', ['class' => 'fas fa-filter']),
				Url::current(),
				['id' => 'filter-checked-btn', 'class' => 'simple btn btn-lg bgc-blue-500 mL-2 c-white', 'title' => \yii::t('toolbar', 'Filter')]
			);
		}

		return $button_filter;
	}

	private function renderButtonPages()
	{
		$button_pages = '';

		if ($this->_button_pages) {
			$button_pages = ButtonDropdown::widget([
				'buttonOptions' => ['class' => 'btn-sm btn-primary ai-c'],
				'label' => \yii::t('toolbar', 'Page Size'),
				'options' => ['class' => 'float-right'],
				'dropdown' => [
					'items' => [
						['label' => '1', 'url' => Url::current(['index', 'page' => 1, 'pageSize' => '1'])],
						['label' => '5', 'url' => Url::current(['index', 'page' => 1, 'pageSize' => '5'])],
						['label' => '10', 'url' => Url::current(['index', 'page' => 1, 'pageSize' => '10'])],
						['label' => '20', 'url' => Url::current(['index', 'page' => 1, 'pageSize' => '20'])],
						['label' => '25', 'url' => Url::current(['index', 'page' => 1, 'pageSize' => '25'])],
						['label' => '50', 'url' => Url::current(['index', 'page' => 1, 'pageSize' => '50'])],
					],
				],
			]);
		}

		return $button_pages;
	}

	private function renderButtonReset()
	{
		$button_reset = '';

		if ($this->_button_reset) {
			$button_reset = Html::a(
				Html::tag('i', '', ['class' => 'fas fa-sync-alt']),
				['index', [], []],
				['class' => 'btn btn-lg bgc-indigo-500 mL-2 c-white', 'title' => \yii::t('toolbar', 'Reset')]
			);
		}

		return $button_reset;
	}

	private function renderIcon()
	{
		return Html::tag($this->_tag_icon_panel, $this->_label_icon_panel, $this->_options_icon_panel);
	}

	private function renderPanelBar()
	{
		$panel_button = Html::begintag($this->_tag_container_panel_button, $this->_options_container_panel_button) .
							Html::begintag($this->_tag_left_panel_button, $this->_options_left_panel_button) .
								$this->renderButtonPages() .
							Html::endTag($this->_tag_left_panel_button) .
							Html::begintag($this->_tag_rigth_panel_button, $this->_options_rigth_panel_button) .
								$this->renderButtonCreate() .
								$this->renderButtonFilter() .
								$this->renderButtonReset() .
							Html::endTag($this->_tag_rigth_panel_button) .
						Html::endTag($this->_tag_container_panel_button);
		return $panel_button;
	}

	private function renderPanelHeader()
	{
		$pageSize = \yii::$app->params['defaultPageSize'];

		if (!is_null(\yii::$app->session->get('pageSize'))) {
			$pageSize = \yii::$app->session->get('pageSize');
		}

		$panel_header = Html::begintag($this->_tag_container_panel_header, $this->_options_container_panel_header) .
							Html::begintag($this->_tag_left_panel_header, $this->_options_left_panel_header) .
								$this->_panel_header_title .
							Html::endTag($this->_tag_left_panel_header) .
							Html::begintag($this->_tag_rigth_panel_header, $this->_options_rigth_panel_header) .
								'{summary}' . ' ' . 'Records per pages: ' . '<b>' . $pageSize . '</b>' .
							Html::endTag($this->_tag_rigth_panel_header) .
						Html::endTag($this->_tag_container_panel_header);
		return $panel_header;
	}

	private function renderTitlePanel()
	{
		if (empty($this->_title_panel)) {
			$this->_title_panel = \yii::t('toolbar', 'Gridview ToolBar');
		}

		return $this->_title_panel;
	}
}
