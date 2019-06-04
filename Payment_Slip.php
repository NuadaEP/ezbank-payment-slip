<?php
	require 'fpdf/fpdf.php';

	class Payment_Slip extends FPDF
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
			$this->Image('images/logo_rendimento_boleto.gif', 1.5, $client ? 0.4 : 7.9, 3, 0);

		    $this->SetXY(1, $client ? 0.5 : 8);
			$this->Cell(6, 0.7, '', 'B', 1, 'R');

			$this->SetFont('Helvetica','B', 12);

		    $this->SetXY(5, $client ? 0.5 : 8);
			$this->Cell(2, 0.7, '104-0', 'L, B', 1, 'C');

			$this->SetFont('Helvetica','B', 10);

		    $this->SetXY(7, $client ? 0.5 : 8);
			$this->Cell(13, 0.7, '00000.00000 00000.00000 00000.00000 0 00000000000000', 'L, B', 1, 'R');

		}

		protected function text_component($title_xy, $title_text, $content_xy, $content_width, $content_text, $content_alignment = 'L')
		{
			$this->setXY($title_xy[0], $title_xy[1]);

			$this->SetFont('Helvetica','', 6);
			$this->Cell($content_width, 0.5, $title_text, 'L', 0, 'L');

			$this->setXY($content_xy[0], $content_xy[1]);
			$this->SetFont('Helvetica', 'B', 8);
			$this->Cell($content_width, 0.5, $content_text, 'B, L', 0, $content_alignment);
		}

		protected function client()
		{
			$this->_header();

			$this->text_component([1, 1.2], 'Beneficiário', [1, 1.5], 8, 'Beneficiário');
			$this->text_component([9, 1.2], 'Agência/Código  do Beneficiário', [9, 1.5], 5, '0000/000000-0');
			$this->text_component([14, 1.2], 'Espécie', [14, 1.5], 1, 'R$');
			$this->text_component([15, 1.2], 'Quantidade', [15, 1.5], 2, '');
			$this->text_component([17, 1.2], 'Nosso número', [17, 1.5], 3, '00000000000000');

			$this->text_component([1, 2], 'Número do documento', [1, 2.3], 6, '0000');
			$this->text_component([7, 2], 'CPF/CJPJ do beneficiário', [7, 2.3], 4, '000.000.000-00');
			$this->text_component([11, 2], 'Vencimento', [11, 2.3], 4, '00/00/0000');
			$this->text_component([15, 2], 'Valor do documento', [15, 2.3], 5, '00,00');

			$this->text_component([1, 2.7], 'Endereço do beneficiário', [1, 3], 19, 'Endereço completo do beneficiário');

			$this->text_component([1, 3.5], '(-) Desconto/abatimentos', [1, 3.8], 3.5, '');
			$this->text_component([4.5, 3.5], '(-) Outras deduções', [4.5, 3.8], 3.5, '');
			$this->text_component([7.5, 3.5], '(+) Mora/multa', [7.5, 3.8], 3.5, '');
			$this->text_component([10.5, 3.5], '(+) Outros acréscimos', [10.5, 3.8], 3.5, '');
			$this->text_component([13.5, 3.5], '(=) Valor cobrado', [13.5, 3.8], 6.5, '');

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

			$this->text_component([1, 8.7], 'Local de pagamento', [1, 9], 14, 'Pagável em qualquer banco até o vencimento');
			$this->text_component([15, 8.7], 'Vencimento', [15, 9], 5, '00/00/0000', 'R');

			$this->text_component([1, 9.5], 'Beneficiário', [1, 9.8], 14, 'Nome completo do beneficiário');
			$this->text_component([15, 9.5], 'Agência/código do beneficiário', [15, 9.8], 5, '0000/000000-0', 'R');

			$this->text_component([1, 10.3], 'Data do documento', [1, 10.6], 4, '00/00/0000');
			$this->text_component([5, 10.3], 'Nº Documento', [5, 10.6], 4, '0000');
			$this->text_component([9, 10.3], 'Espécie doc.', [9, 10.6], 2, 'Real');
			$this->text_component([11, 10.3], 'Aceite', [11, 10.6], 1, '');
			$this->text_component([12, 10.3], 'Data processamento', [12, 10.6], 3, '00/00/0000');
			$this->text_component([15, 10.3], 'Nosso Número', [15, 10.6], 5, '00000000000000', 'R');

			$this->text_component([1, 11.1], 'Uso do banco', [1, 11.4], 4, '');
			$this->text_component([5, 11.1], 'Espécie', [5, 11.4], 4, 'R$');
			$this->text_component([9, 11.1], 'Quantidade', [9, 11.4], 4, '');
			$this->text_component([12, 11.1], 'Valor documento', [12, 11.4], 3, '');
			$this->text_component([15, 11.1], 'Valor documento', [15, 11.4], 5, '00,00', 'R');

			$this->setXY(1, 11.9);
			$this->Cell(14, 3.6, '', 1, 0, 'L');
			$this->SetFont('Helvetica','', 6);
			$this->setXY(1, 11.9);
			$this->Cell(15, 0.5, 'Inscrições(Texto de responsabilidade do beneficiário)', 0, 0, 'L');
			$this->SetFont('Helvetica','B', 7);
			$this->setXY(1, 12.5);
			$this->Cell(15, 0.5, 'Campo com as instruções n1', 0, 0, 'L');
			$this->setXY(1, 13);
			$this->Cell(15, 0.5, 'Campo com as instruções n2', 0, 0, 'L');
			$this->setXY(1, 13.5);
			$this->Cell(15, 0.5, 'Campo com as instruções n3', 0, 0, 'L');
			$this->text_component([15, 11.9], '(-) Desconto/abatimentos', [15, 12.2], 5, '', 'R');
			$this->text_component([15, 12.6], '(-) Outras deduções', [15, 12.9], 5, '', 'R');
			$this->text_component([15, 13.3], '(+) Mora/multa', [15, 13.6], 5, '', 'R');
			$this->text_component([15, 14], '(+) Outros acréscimos', [15, 14.3], 5, '', 'R');
			$this->text_component([15, 14.7], '(=) Valor cobrado', [15, 15], 5, '', 'R');

			$this->setXY(1, 15.5);
			$this->Cell(19, 3.6, '', 1, 0, 'L');
			$this->SetFont('Helvetica','', 6);
			$this->setXY(1, 15.5);
			$this->Cell(15, 0.5, 'Pagador', 0, 0, 'L');
			$this->SetFont('Helvetica','B', 7);
			$this->setXY(1, 15.9);
			$this->Cell(15, 0.5, 'Nome completo do pagador', 0, 0, 'L');

			$this->SetFont('Helvetica','', 8);
			$this->setXY(1, 17);
			$this->Cell(15, 0.5, 'Sacador/avalista', 0, 0, 'L');

			$this->SetFont('Helvetica','B', 7);
			$this->setXY(1, 18);
			$this->Cell(15, 0.5, 'Endereço 1', 0, 0, 'L');
			$this->setXY(1, 18.5);
			$this->Cell(15, 0.5, 'Endereço 2', 0, 0, 'L');

			$this->setXY(15, 18.6);
			$this->Cell(2, 0.5, 'Cód. baixa', 'L', 0, 'L');

			$this->setXY(14, 19);
			$this->Cell(2, 0.5, 'Autenticação mecânica - Ficha de compensação', 0, 0, 'L');

			$this->Image('images/bar_code.png', 1, 19.5, 12, 0);

		}
	}