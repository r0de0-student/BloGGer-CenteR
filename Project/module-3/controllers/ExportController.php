<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class ExportController {
    private $reportModel;
    
    public function __construct($pdo) {
        require_once __DIR__ . '/../models/Report.php';
        $this->reportModel = new Report($pdo);
    }
    
    // ==================== ЭКСПОРТ ПОЛЬЗОВАТЕЛЕЙ ====================
    
    public function usersToExcel() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') exit;
        
        $data = $this->reportModel->getUsersReport();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Имя');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Роль');
        $sheet->setCellValue('E1', 'Статус');
        $sheet->setCellValue('F1', 'Дата регистрации');
        
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item['id']);
            $sheet->setCellValue('B' . $row, $item['name']);
            $sheet->setCellValue('C' . $row, $item['email']);
            $sheet->setCellValue('D' . $row, $item['role']);
            $sheet->setCellValue('E' . $row, $item['status']);
            $sheet->setCellValue('F' . $row, $item['reg_date']);
            $row++;
        }
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="users_report.xlsx"');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    
    public function usersToWord() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') exit;
        
        $data = $this->reportModel->getUsersReport();
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        
        $section->addTitle('Отчёт по пользователям', 1);
        $section->addText('Дата формирования: ' . date('d.m.Y H:i:s'));
        
        $table = $section->addTable();
        $table->addRow();
        $table->addCell(500)->addText('ID');
        $table->addCell(2000)->addText('Имя');
        $table->addCell(3000)->addText('Email');
        $table->addCell(1500)->addText('Роль');
        $table->addCell(1500)->addText('Статус');
        
        foreach ($data as $item) {
            $table->addRow();
            $table->addCell(500)->addText($item['id']);
            $table->addCell(2000)->addText($item['name']);
            $table->addCell(3000)->addText($item['email']);
            $table->addCell(1500)->addText($item['role']);
            $table->addCell(1500)->addText($item['status']);
        }
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment;filename="users_report.docx"');
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output');
        exit;
    }
    
    // ==================== ЭКСПОРТ СТАТЕЙ ====================
    
    public function postsToExcel() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') exit;
        
        $data = $this->reportModel->getPostsReport();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Заголовок');
        $sheet->setCellValue('C1', 'Автор');
        $sheet->setCellValue('D1', 'Блог');
        $sheet->setCellValue('E1', 'Просмотры');
        $sheet->setCellValue('F1', 'Дата');
        
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item['id']);
            $sheet->setCellValue('B' . $row, $item['title']);
            $sheet->setCellValue('C' . $row, $item['author_name']);
            $sheet->setCellValue('D' . $row, $item['blog_name']);
            $sheet->setCellValue('E' . $row, $item['views_count']);
            $sheet->setCellValue('F' . $row, $item['pub_date']);
            $row++;
        }
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="posts_report.xlsx"');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    
    public function postsToWord() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') exit;
        
        $data = $this->reportModel->getPostsReport();
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        
        $section->addTitle('Отчёт по статьям', 1);
        $section->addText('Дата формирования: ' . date('d.m.Y H:i:s'));
        
        $table = $section->addTable();
        $table->addRow();
        $table->addCell(500)->addText('ID');
        $table->addCell(4000)->addText('Заголовок');
        $table->addCell(2000)->addText('Автор');
        $table->addCell(1500)->addText('Просмотры');
        
        foreach ($data as $item) {
            $table->addRow();
            $table->addCell(500)->addText($item['id']);
            $table->addCell(4000)->addText($item['title']);
            $table->addCell(2000)->addText($item['author_name']);
            $table->addCell(1500)->addText($item['views_count']);
        }
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment;filename="posts_report.docx"');
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output');
        exit;
    }
    
    // ==================== ЭКСПОРТ ТОП БЛОГОВ ====================
    
    public function topBlogsToExcel() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') exit;
        
        $data = $this->reportModel->getTopBlogsReport();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Название блога');
        $sheet->setCellValue('C1', 'Владелец');
        $sheet->setCellValue('D1', 'Статей');
        $sheet->setCellValue('E1', 'Подписчиков');
        $sheet->setCellValue('F1', 'Просмотров');
        
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item['id']);
            $sheet->setCellValue('B' . $row, $item['blog_name']);
            $sheet->setCellValue('C' . $row, $item['owner_name']);
            $sheet->setCellValue('D' . $row, $item['posts_count']);
            $sheet->setCellValue('E' . $row, $item['subscribers_count']);
            $sheet->setCellValue('F' . $row, $item['total_views']);
            $row++;
        }
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="top_blogs_report.xlsx"');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    
    public function topBlogsToWord() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') exit;
        
        $data = $this->reportModel->getTopBlogsReport();
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        
        $section->addTitle('Топ блогов по подписчикам', 1);
        $section->addText('Дата формирования: ' . date('d.m.Y H:i:s'));
        
        $table = $section->addTable();
        $table->addRow();
        $table->addCell(3000)->addText('Название блога');
        $table->addCell(2000)->addText('Владелец');
        $table->addCell(1500)->addText('Подписчиков');
        $table->addCell(1500)->addText('Просмотров');
        
        foreach ($data as $item) {
            $table->addRow();
            $table->addCell(3000)->addText($item['blog_name']);
            $table->addCell(2000)->addText($item['owner_name']);
            $table->addCell(1500)->addText($item['subscribers_count']);
            $table->addCell(1500)->addText($item['total_views']);
        }
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment;filename="top_blogs_report.docx"');
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output');
        exit;
    }
}
?>