<?php
class pant_edicion_reporte extends toba_ei_pantalla
{
	function generar_layout()
	{
		$www=toba::proyecto()->get_www();
    	echo toba_js::incluir($www['url'].'/js/codemirror/codemirror.js');
    	echo toba_js::incluir($www['url'].'/js/codemirror/sql.js');
    	echo "<link rel='stylesheet' href='./js/codemirror/codemirror.css'/>";

    	echo "<style>
    			.CodeMirror {					
					font-size: 14px;
				}
				.CodeMirror cm-s-default{
					height: 220px;
				}
			</style>
    	";
		
		echo "<table>
				<tbody>
				<tr>
					<td valign='top'>";

						$this->dep('form')->generar_html();
		
		echo "		</td>
					<td valign='top'>";

						$this->dep('form_columnas')->generar_html();

		echo "		</td>
				</tr>
				<tr>
					<td colspan='2'>";

						$this->dep('form_ml')->generar_html();

		echo "		</td>;
				</tr>
				<tr>
					<td colspan='2'>";

						$this->dep('form_ml_cortes')->generar_html();

		echo "		</td>
				</tr>
				</tbody>
			</table>";

	}

}
?>