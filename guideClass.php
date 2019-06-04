<?php
	require 'fpdf/fpdf.php';

	class Guide extends FPDF
	{
		public function __construct()
		{
			parent::__construct('P', 'cm');

			$this->AddPage();
			$this->SetMargins(0, 0, 0);
			$this->SetAutoPageBreak(false);

			$this->client();
			$this->company();

			$this->Output();
		}

		protected function _header($client = true)
		{
			$this->Image('images/alboom-preto.png', 1.5, $client ? 0.4 : 7.9, 3, 0);

		    $this->SetXY(1, $client ? 0.5 : 8);
			$this->Cell(6, 0.7, '', 'B', 1, 'R');

			$this->SetFont('Helvetica','B', 12);

		    $this->SetXY(5, $client ? 0.5 : 8);
			$this->Cell(2, 0.7, '104-0', 'L, B', 1, 'C');

			$this->SetFont('Helvetica','B', 10);

		    $this->SetXY(7, $client ? 0.5 : 8);
			$this->Cell(13, 0.7, '00000.00000 00000.00000 00000.00000 0 00000000000000', 'L, B', 1, 'R');

		}

		protected function text_component($title_xy, $title_text, $content_xy, $content_width, $content_text)
		{
			$this->setXY($title_xy[0], $title_xy[1]);

			$this->SetFont('Helvetica','', 6);
			$this->Cell($content_width, 0.5, $title_text, 'L', 0, 'L');

			$this->setXY($content_xy[0], $content_xy[1]);
			$this->SetFont('Helvetica', 'B', 8);
			$this->Cell($content_width, 0.5, $content_text, 'B, L', 0, 'L');
		}

		protected function client()
		{
			$this->_header();

			$this->text_component([1, 1.2], 'Beneficiário', [1, 1.4], 8, 'Beneficiário');
			$this->text_component([9, 1.2], 'Agência/Código  do Beneficiário', [9, 1.4], 5, '0000/000000-0');
			$this->text_component([14, 1.2], 'Espécie', [14, 1.4], 1, 'R$');
			$this->text_component([15, 1.2], 'Quantidade', [15, 1.4], 2, '');
			$this->text_component([17, 1.2], 'Nosso número', [17, 1.4], 3, '00000000000000');

			$this->text_component([1, 1.9], 'Número do documento', [1, 2.2], 6, '0000');
			$this->text_component([7, 1.9], 'CPF/CJPJ do beneficiário', [7, 2.2], 4, '000.000.000-00');
			$this->text_component([11, 1.9], 'Vencimento', [11, 2.2], 4, '00/00/0000');
			$this->text_component([15, 1.9], 'Valor do documento', [15, 2.2], 5, '00,00');

			$this->text_component([1, 2.7], 'Endereço do beneficiário', [1, 3], 19, 'Endereço completo do beneficiário');

			$this->text_component([1, 3.5], '(-) Desconto/abatimentos', [1, 3.8], 3.5, '');
			$this->text_component([4.5, 3.5], '(-) Outras deduções', [4.5, 3.8], 3.5, '');
			$this->text_component([7.5, 3.5], '(+) Mora/multa', [7.5, 3.8], 3.5, '');
			$this->text_component([10.5, 3.5], '(+) Outros acréscimos', [10.5, 3.8], 3.5, '');
			$this->text_component([13.5, 3.5], '(=) Valor cobrado', [13.5, 3.8], 6.5, '');

			$this->text_component([1, 4.2], 'Pagador', [1, 4.5], 19, 'Nome completo do pagador');

			$this->text_component([1, 4.2], 'Pagador', [1, 4.5], 19, 'Nome completo do pagador');

			$this->setXY(1, 5);

			$this->SetFont('Helvetica','', 6);
			$this->Cell(15, 0.5, 'Demonstrativo', 0, 0, 'L');

			$this->split_here();

		}

		protected function split_here()
		{
			$this->setXY(17.6, 6);

			$this->SetFont('Helvetica','', 6);
			$this->Cell(15, 0.5, 'Corte na linha pontilhada', 0, 0, 'L');

			for ($i=1; $i < 20; $i = $i + 0.3)
			{
				$this->setXY($i, 6);

				$this->Cell(0.2, 0.5, '', 'B', 0, 'L');
			}
		}

		protected function company()
		{
			$this->_header(false);

		}
	}