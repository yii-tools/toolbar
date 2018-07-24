/**
 * (c) CJT TERABYTE INC
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 *        @link: https://github.com/cjtterabytesoft/adminator
 *      @author: Wilmer Arámbula <terabytefrelance@gmail.com>
 *   @copyright: (c) CJT TERABYTE INC
 *          @js: [toolbar]
 *       @since: 1.0
 *         @yii: 3.0
 **/

/***********************************************************************************************************************
 * Filter GridView Select Rows                                                                                         *
 ***********************************************************************************************************************/

(function () {
	filterGridSelect = function(grid, button, route, message) {
		$(button).click(function() {
    		var ids = $(grid).yiiGridView('getSelectedRows');
        
			if (!ids.length) {
				bootbox.alert(message);
				} else if (route) {
					var form = $('<form action=' + route + ' method=\"post\"></form>'),                
						csrfParam = $('meta[name=csrf-param]').prop('content'),
						csrfToken = $('meta[name=csrf-token]').prop('content');

				if (csrfParam) {
					form.append('<input type=\"hidden\" name=' + csrfParam + ' value=' + csrfToken + ' />');
				}
							
				$.each(ids, function(index, id) {
					form.append('<input type=\"hidden\" name=\"' + 'ids' + '[]\" value=' + id + ' />');
				});
        
				form.appendTo('body').submit();
			}
		});
	};
})();