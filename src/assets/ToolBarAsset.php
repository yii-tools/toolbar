<?php

/**
 * (c) CJT TERABYTE INC
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 *        @link: https://github.com/cjtterabytesoft/adminator
 *      @author: Wilmer Arámbula <terabytefrelance@gmail.com>
 *   @copyright: (c) CJT TERABYTE INC
 *      @assets: [ToolBarAsset]
 *       @since: 1.0
 *         @yii: 3.0
 **/

namespace cjtterabytesoft\toolbar\assets;

use yii\web\AssetBundle;

class ToolBarAsset extends AssetBundle
{
	public $sourcePath = '@cjtterabytesoft/toolbar/assets/';

	public $js = [
		'js/toolbar.js',
	];

	public $publishOptions = [
		'only' => [
			'toolbar.js',
		],
	];
}
