<?php

/**
 * (c) CJT TERABYTE INC
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 *        @link: https://github.com/cjtterabytesoft/alert
 *      @author: Wilmer Arámbula <terabytefrelance@gmail.com>
 *   @copyright: (c) CJT TERABYTE INC
 *     @widgets: [Export]
 *       @since: 1.0
 *         @yii: 3.0
 **/

namespace cjtterabytesoft\widgets;

use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use yii\base\InvalidConfigException;
use yii\base\Widget;

/**
 * Export File diferents format Csv, Excel, Html, Pdf, Word.
 */
class Export extends Widget
{
	/**
	 * @var string Charset export csv.
	 */
	public $_csvCharset = 'UTF-8';

	/**
	 * @var \yii\data\DataProviderInterface the data provider for the view. This property is required.
	 */
	public $_dataProvider;

	/**
	 * @var \app\model\searchModel.
	 */
	public $_searchModel;

	/**
	 * @var string tableName.
	 */
	public $_tableName= '';

	/**
	 * @var string Title Export.
	 */
	public $_title = '';

	/**
	 * Initializes the view.
	 */
	public function init()
	{
		parent::init();

		if (empty($this->_dataProvider)) {
			throw new InvalidConfigException('The "dataProvider" property must be set.');
		}

		if (empty($this->_searchModel)) {
			throw new InvalidConfigException('The "dataProvider" property must be set.');
		}

		$this->_tableName = $this->_searchModel->tableName();

		if (empty($this->_title)) {
			$this->_title = $this->_tableName;
		}
	}

	/**
	 * @return file Csv Export.
	 */
	public function exportCsv()
	{
		$csvCharset = $this->_csvCharset;
		$fields = $this->getFieldsKeys($this->_searchModel->exportFields());
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Description: File Transfer');
		header('Content-Type: text/csv');
		$filename = $this->_tableName . '.csv';
		header('Content-Disposition: attachment;filename=' . $filename);
		header('Content-Transfer-Encoding: binary');
		$fp = fopen('php://output', 'w');
		fwrite($fp, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
		if ($fp) {
			$items = [];
			$i = 0;
			foreach ($fields as $one) {
				$items[$i] = $one;
				$i++;
			}
			fwrite($fp, implode($items, ',') . "\n");
			$items = [];
			$i = 0;
			foreach ($this->_dataProvider->getModels() as $model) {
				foreach ($this->_searchModel->exportFields() as $one) {
					$item = str_replace('"', '\"', is_string($one) ? $model[$one] : $one($model));
					$items[$i] = ($item) ? '"' . $item . '"' : $item;
					$i++;
				}
				fwrite($fp, implode($items, ',') . "\n");
				$items = [];
				$i = 0;
			}
		}
		fclose($fp);
	}

	/**
	 * @return file Excel Export.
	 */
	public function exportExcel()
	{
		$fields = $this->getFieldsKeys($this->_searchModel->exportFields());
		$objPHPExcel = new Spreadsheet();
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle($this->_title);
		$letter = 65;
		foreach ($fields as $one) {
			$objPHPExcel->getActiveSheet()->getColumnDimension(chr($letter))->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->setCellValue(chr($letter) . '1', $this->_searchModel->getAttributeLabel($one));
			$objPHPExcel->getActiveSheet()->getStyle(chr($letter) . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$letter++;
		}
		$row = 2;
		$letter = 65;
		foreach ($this->_dataProvider->getModels() as $model) {
			foreach ($this->_searchModel->exportFields() as $one) {
				$objPHPExcel->getActiveSheet()->setCellValue(chr($letter) . $row, (is_string($one)) ? $model[$one] : $one($model));
				$objPHPExcel->getActiveSheet()->getStyle(chr($letter) . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$letter++;
			}
			$letter = 65;
			$row++;
		}
		header('Content-Type: application/vnd.ms-excel');
		$filename = $this->_tableName . '.xlsx';
		header('Content-Disposition: attachment;filename=' . $filename);
		header('Cache-Control: max-age=0');
		$objWriter = new Xlsx($objPHPExcel);
		$objWriter->save('php://output');
	}

	/**
	 * @return file Htlm Export.
	 */
	public function exportHtml()
	{
		$fields = $this->getFieldsKeys($this->_searchModel->exportFields());
		$phpWord = new PhpWord();
		$section = $phpWord->addSection();
		$section->addTitle($this->_title);
		$table = $section->addTable(['name' => 'Tahoma', 'size' => 10, 'align' => 'center',]);
		$table->addRow(300, ['exactHeight' => true]);
		foreach ($fields as $one) {
			$table->addCell(1500, [
				'bgColor' => 'eeeeee',
				'valign' => 'center',
				'borderTopSize' => 5,
				'borderRightSize' => 5,
				'borderBottomSize' => 5,
				'borderLeftSize' => 5,
			])->addText($this->_searchModel->getAttributeLabel($one), ['bold' => true, 'size' => 10], ['align' => 'center']);
		}
		foreach ($this->_dataProvider->getModels() as $model) {
			$table->addRow(300, ['exactHeight' => true]);
			foreach ($this->_searchModel->exportFields() as $one) {
				$table->addCell(1500, [
					'valign' => 'center',
					'borderTopSize' => 1,
					'borderRightSize' => 1,
					'borderBottomSize' => 1,
					'borderLeftSize' => 1,
				])->addText('<p style="margin-left: 10px;">' . (is_string($one)) ? $model[$one] : $one($model) . '</p>', ['bold' => false, 'size' => 10], ['align' => 'right']);
			}
		}
		header('Content-Type: application/html');
		$filename = $this->_tableName . '.html';
		header('Content-Disposition: attachment;filename=' . $filename . ' ');
		header('Cache-Control: max-age=0');
		$objWriter = IOFactory::createWriter($phpWord, 'HTML');
		$objWriter->save('php://output');
	}

	/**
	 * @return file Pdf Export.
	 */
	public function exportPdf()
	{
		$fields = $this->getFieldsKeys($this->_searchModel->exportFields());
		$options = new Options();
		$options->set('defaultFont', 'times');
		$dompdf = new Dompdf($options);
		$html = '<html><body>';
		$html .= '<h1>' . '<center>' . $this->_title . '</center>' . '</h1>';
		$html .= '<table width="100%" cellspacing="0" cellpadding="0">';
		$html .= '<tr style="background-color: #ececec;">';
		foreach ($fields as $one) {
			$html .= '<td style="border: 2px solid #cccccc; text-align: center; font-weight: 500;">' . $this->_searchModel->getAttributeLabel($one) . '</td>';
		}
		$html .= '</tr>';
		foreach ($this->_dataProvider->getModels() as $model) {
			$html .= '<tr>';
			foreach ($this->_searchModel->exportFields() as $one) {
				switch (true) {
					case is_string($one):
						$html .= '<td style="border: 1px solid #cccccc; text-align: left; font-weight: 300; padding-left: 10px;">' . $model[$one] . '</td>';
						break;
					default:
						$html .= '<td style="border: 1px solid #cccccc; text-align: left; font-weight: 300; padding-left: 10px;">' . $one($model) . '</td>';
						break;
				}
			}
			$html .= '</tr>';
		}
		$html .= '</table>';
		$html .= '</body></html>';
		$dompdf->loadHtml($html);
		$dompdf->setPaper('letter', 'landscape');
		$dompdf->render();
		$dompdf->stream($this->_tableName . '_' . time());
	}

	/**
	 * @return file Word Export.
	 */
	public function exportWord()
	{
		$fields = $this->getFieldsKeys($this->_searchModel->exportFields());
		$phpWord = new PhpWord();
		$phpWord->getCompatibility()->setOoxmlVersion(15);
		$section = $phpWord->addSection();
		$sectionStyle = $section->getSettings();
		$sectionStyle->setLandscape();
		$sectionStyle->setBorderTopColor('C0C0C0');
		$sectionStyle->setMarginTop(300);
		$sectionStyle->setMarginRight(300);
		$sectionStyle->setMarginBottom(300);
		$sectionStyle->setMarginLeft(300);
		$phpWord->addTitleStyle(1, ['name' => 'HelveticaNeueLT Std Med', 'size' => 16], ['align' => 'center']); //h
		$section->addTitle($this->_title);
		$table = $section->addTable(
			[
				'name' => 'Tahoma',
				'align' => 'center',
				'cellMarginTop' => 30,
				'cellMarginRight' => 30,
				'cellMarginBottom' => 30,
				'cellMarginLeft' => 30,
			]
		);
		$table->addRow(300, ['exactHeight' => true]);
		foreach ($fields as $one) {
			$table->addCell(1500, [
				'bgColor' => 'eeeeee',
				'valign' => 'center',
				'borderTopSize' => 5,
				'borderRightSize' => 5,
				'borderBottomSize' => 5,
				'borderLeftSize' => 5,
			])->addText($this->_searchModel->getAttributeLabel($one), ['bold' => true, 'size' => 10], ['align' => 'center']);
		}
		foreach ($this->_dataProvider->getModels() as $model) {
			$table->addRow(300, ['exactHeight' => true]);
			foreach ($this->_searchModel->exportFields() as $one) {
				$table->addCell(1500, [
					'valign' => 'center',
					'borderTopSize' => 1,
					'borderRightSize' => 1,
					'borderBottomSize' => 1,
					'borderLeftSize' => 1,
				])->addText(is_string($one) ? $model[$one] : $one($model), ['bold' => false, 'size' => 10], ['align' => 'left']);
			}
		}
		header('Content-Type: application/vnd.ms-word');
		$filename = $this->_tableName . '.docx';
		header('Content-Disposition: attachment;filename=' . $filename . ' ');
		header('Cache-Control: max-age=0');
		$objWriter = IOFactory::createWriter($phpWord, 'Word2007');
		$objWriter->save('php://output');
	}

	/**
	 * @return array Fields List.
	 */
	private function getFieldsKeys($fieldsSended)
	{
		$fields = [];
		$i = 0;

		foreach ($fieldsSended as $key => $value) {
			switch (true) {
				case is_int($key):
					$fields[$i] = $value;
					break;
				default:
					$fields[$i] = $key;
					break;
			}
			$i++;
		}

		return $fields;
	}
}
