<?php
ob_start(); // 🔥 evita salida basura

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

try {

    /* VALIDAR ARCHIVO */
    if(!isset($_FILES['excel'])){
        throw new Exception("No se recibió archivo");
    }

    $tmpFile = $_FILES['excel']['tmp_name'];

    /* VALIDAR DATOS */
    if(!isset($_POST['datos'])){
        throw new Exception("No se recibieron datos");
    }

    $data = json_decode($_POST['datos'], true);

    if(!$data){
        throw new Exception("Datos inválidos");
    }

    /* CARGAR EXCEL */
    $spreadsheet = IOFactory::load($tmpFile);
    $sheet = $spreadsheet->getActiveSheet();

    /* ÚLTIMA FILA */
    $fila = $sheet->getHighestDataRow() + 1;

    /* INSERTAR */
    foreach ($data as $p) {

        $sheet->setCellValue("A$fila", $p["apellido_paterno"] ?? "");
        $sheet->setCellValue("B$fila", $p["apellido_materno"] ?? "");
        $sheet->setCellValue("C$fila", $p["nombre"] ?? "");
        $sheet->setCellValue("D$fila", $p["fecha_nacimiento"] ?? "");
        $sheet->setCellValue("E$fila", $p["curp"] ?? "");
        $sheet->setCellValue("F$fila", $p["telefono"] ?? "");
        $sheet->setCellValue("G$fila", $p["domicilio"] ?? "");
        $sheet->setCellValue("H$fila", $p["codigo_postal"] ?? "");
        $sheet->setCellValue("I$fila", $p["localidad"] ?? "");
        $sheet->setCellValue("J$fila", $p["municipio"] ?? "");
        $sheet->setCellValue("K$fila", $p["nombre_responsable"] ?? "");
        $sheet->setCellValue("L$fila", $p["telefono_responsable"] ?? "");
        $sheet->setCellValue("M$fila", $p["sexo"] ?? "");
        $sheet->setCellValue("N$fila", $p["edad"] ?? "");
        $sheet->setCellValue("O$fila", $p["diagnostico"] ?? "");
        $sheet->setCellValue("P$fila", $p["origen"] ?? "");
        $sheet->setCellValue("Q$fila", $p["destino"] ?? "");
        $sheet->setCellValue("R$fila", $p["no_traslado"] ?? "");

        $fila++;
    }

    /* LIMPIAR BUFFER 🔥 */
    ob_end_clean();

    /* HEADERS CORRECTOS */
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="beneficiarios_actualizado.xlsx"');
    header('Cache-Control: max-age=0');

    /* GUARDAR SALIDA */
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');

    exit;

} catch (Exception $e) {

    ob_end_clean();

    echo "ERROR: " . $e->getMessage();
}