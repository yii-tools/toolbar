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

use cjtterabytesoft\widgets\assets\ToolBarAsset;
use yii\base\Widget;
use yii\bootstrap4\ButtonDropdown;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class ToolBar extends Widget
{
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
	 * @var string use to panel header title
	 */
	public $_panel_header_title = '';

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
	 * @var bool Show/Hidden Summary Label
	 */
	public $_summary = false;

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
	 * @var array Templates
	 */
	public $_templates = [];

	/**
	 * @var array Buttons
	 */
	public $_toolbar = [];

	/**
	 * @var bool show/hidden panel button pages
	 */
	public $_button_pages = false;

	/**
	 * @var bool show/hidden panel button export
	 */
	public $_button_export = false;

	/**
	 * @var bool whether the label should be HTML-encoded.
	 */
	public $_encodeLabel = false;

	/**
	 * @var bool whether the JS file should be registered.
	 */
	public $_registerJs = true;

	/**
	 * @var array Options Filter.
	 */
	public $_optionsFilter = [];

	/**
	 * @var string Message Filter Error.
	 */
	public $_messageFilter = '';

	/**
	 * @var array Model Search.
	 */
	public $_modelSearch = [];

	/**
	 * @var string Query Params.
	 */
	public $_queryParams = '';

	/**
	 * @var string Record All.
	 */
	public $_getall = '';


	/**
	 * Initializes the widget.
	 * If you override this method, make sure you call the parent implementation first.
	 */
	public function init()
	{
		parent::init();

		if (empty($this->_optionsFilter['message_filter'])) {
			$this->_messageFilter = \yii::t('toolbar', 'Please select one or more items from the list.');
		}

		$iconpanel = $this->renderIcon();
		$titlepanel = $this->renderTitlePanel();

		$this->_panel_header_title = $iconpanel . '&nbsp' . '<b>' . $titlepanel . '</b>';
	}

	/**
	 * Run the widget.
	 * If you override this method, make sure you call the parent implementation first.
	 */
	public function run()
	{
		if (!empty($this->_optionsFilter['id_grid']) && !empty($this->_optionsFilter['id_button']) && !empty($this->_optionsFilter['route_filter'])) {
			$id_grid = $this->_optionsFilter['id_grid'];
			$id_button = $this->_optionsFilter['id_button'];
			$route_filter = $this->_optionsFilter['route_filter'];
			$this->view->registerJs("filterGridSelect('#$id_grid', '#$id_button', '$route_filter', '$this->_messageFilter');");
		}

		if ($this->_registerJs) {
			$toolbar = new ToolBarAsset();
			$toolbar->register($this->view);
		}

		echo $this->renderPanelHeader() . $this->renderPanelBar();
	}

	private function renderButtonExport()
	{
		$button_export = '';

		if ($this->_button_export) {
			$button_export = ButtonDropdown::widget([
				'buttonOptions' => ['class' => 'btn-primary ai-c mL-2'],
				'encodeLabel' => $this->_encodeLabel,
				'label' => Html::tag('i', '', ['class' => 'fas fa-file-export']),
				'options' => ['class' => 'float-right'],
				'dropdown' => [
					'encodeLabels' => $this->_encodeLabel,
					'items' => [
						Html::tag('h6', \yii::t('toolbar', 'Export Menu'), ['class' => 'dropdown-header']),
						Html::tag('div', '', ['class' => 'dropdown-divider']),
						[
							'label' => Html::tag('i', '', ['class' => 'fas fa-file-code']) . ' ' . 'CSV',
							'url' => Url::to(['export/csv']),
							'linkOptions' => [
								'data' => [
									'method' => 'post',
									'params' => [
										'model' => $this->_modelSearch,
									],
								],
							],
						],
						['label' => Html::tag('i', '', ['class' => 'fas fa-file-excel']) . ' ' . 'EXCEL', 'url' => Url::current()],
						['label' => Html::tag('i', '', ['class' => 'fas fa-file-pdf']) . ' ' . 'PDF', 'url' => Url::current()],
						['label' => Html::tag('i', '', ['class' => 'fas fa-file-word']) . ' ' . 'WORD', 'url' => Url::current()],
					],
				],
			]);
		}

		return $button_export;
	}

	private function renderButtonPages()
	{
		$button_pages = '';

		if ($this->_button_pages) {
			$button_pages = ButtonDropdown::widget([
				'buttonOptions' => ['class' => 'btn-primary ai-c mL-2'],
				'encodeLabel' => $this->_encodeLabel,
				'label' => Html::tag('i', '', ['class' => 'fas fa-cog']),
				'options' => ['class' => 'float-right'],
				'dropdown' => [
					'items' => [
						Html::tag('h6', \yii::t('toolbar', 'Page Size Menu'), ['class' => 'dropdown-header']),
						Html::tag('div', '', ['class' => 'dropdown-divider']),
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

	private function renderIcon()
	{
		return Html::tag($this->_tag_icon_panel, $this->_label_icon_panel, $this->_options_icon_panel);
	}

	private function renderPanelBar()
	{
		$panel_button = Html::begintag($this->_tag_container_panel_button, $this->_options_container_panel_button) .
							$this->renderToolBar() .
						Html::endTag($this->_tag_container_panel_button);
		return $panel_button;
	}

	private function renderPanelHeader()
	{
		$pageSize = \yii::$app->params['defaultPageSize'];

		if (\yii::$app->session->get('pageSize') !== null) {
			$pageSize = \yii::$app->session->get('pageSize');
		}

		$summary = ($this->_summary) ? '{summary}' . ' ' . 'Records per pages: ' . '<b>' . $pageSize . '</b>' : ' ';

		$panel_header = Html::begintag($this->_tag_container_panel_header, $this->_options_container_panel_header) .
							Html::begintag($this->_tag_left_panel_header, $this->_options_left_panel_header) .
								$this->_panel_header_title .
							Html::endTag($this->_tag_left_panel_header) .
							Html::begintag($this->_tag_rigth_panel_header, $this->_options_rigth_panel_header) .
								$summary .
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

	private function renderToolBar()
	{
		$buttons_left = '';
		$buttons_rigth = '';

		ArrayHelper::setValue($this->_toolbar, 'pages.0', $this->renderButtonPages());
		ArrayHelper::setValue($this->_toolbar, 'export.0', $this->renderButtonExport());

		foreach ($this->_templates as $items => $buttons) {
			foreach ($buttons as $item => $button) {
				if (!empty(ArrayHelper::getValue($this->_toolbar, $button, ''))) {
					switch ($items) {
						case 'left':
							$buttons_left .= implode(',', ArrayHelper::getValue($this->_toolbar, $button, ''));
							break;
						case 'rigth':
							$buttons_rigth .= implode(',', ArrayHelper::getValue($this->_toolbar, $button, ''));
							break;
					}
				}
			}
		}

		return Html::tag($this->_tag_left_panel_button, $buttons_left, $this->_options_left_panel_button) .
			   Html::tag($this->_tag_rigth_panel_button, $buttons_rigth, $this->_options_rigth_panel_button);
	}
}
