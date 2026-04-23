<?php
class ReportController {
    private $reportModel;
    
    public function __construct($pdo) {
        require_once __DIR__ . '/../models/Report.php';
        $this->reportModel = new Report($pdo);
    }
    
    /**
     * Главная страница отчётов
     */
    public function index() {
        requireLogin();  // Требуем авторизацию
        
        require_once __DIR__ . '/../views/reports/index.php';
    }
    
    /**
     * Отчёт по пользователям (только админ)
     */
    public function users() {
        requireAdmin();  // Только администратор
        
        $data = $this->reportModel->getUsersReport();
        require_once __DIR__ . '/../views/reports/users.php';
    }
    
    /**
     * Отчёт по статьям (только админ)
     */
    public function posts() {
        requireAdmin();  // Только администратор
        
        $data = $this->reportModel->getPostsReport();
        require_once __DIR__ . '/../views/reports/posts.php';
    }
    
    /**
     * Топ блогов (только админ)
     */
    public function topBlogs() {
        requireAdmin();  // Только администратор
        
        $data = $this->reportModel->getTopBlogsReport();
        require_once __DIR__ . '/../views/reports/top-blogs.php';
    }
    
    /**
     * Статистика автора (для всех авторизованных пользователей)
     */
    public function authorStats() {
        requireLogin();  // Требуем авторизацию
        
        $stats = $this->reportModel->getAuthorStats($_SESSION['user_id']);
        require_once __DIR__ . '/../views/reports/author-stats.php';
    }
    
    /**
     * Активность пользователей (доп. отчёт, только админ)
     */
    public function userActivity() {
        requireAdmin();  // Только администратор
        
        $data = $this->reportModel->getUserActivityReport();
        require_once __DIR__ . '/../views/reports/user-activity.php';
    }
    
    /**
     * Статистика по дням (доп. отчёт, только админ)
     */
    public function dailyStats() {
        requireAdmin();  // Только администратор
        
        $data = $this->reportModel->getDailyStatsReport(7);
        require_once __DIR__ . '/../views/reports/daily-stats.php';
    }
    
    /**
     * Экспорт отчёта по пользователям в Excel
     */
    public function exportUsersExcel() {
        requireAdmin();
        
        $data = $this->reportModel->getUsersReport();
        
        // Подключаем PhpSpreadsheet
        require_once __DIR__ . '/../vendor/autoload.php';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Заголовки
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Имя');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Роль');
        $sheet->setCellValue('E1', 'Статус');
        $sheet->setCellValue('F1', 'Дата регистрации');
        
        // Данные
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
        
        // Сохраняем файл
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="users_report.xlsx"');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    
    /**
     * Экспорт отчёта по пользователям в Word
     */
    public function exportUsersWord() {
        requireAdmin();
        
        $data = $this->reportModel->getUsersReport();
    
        
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
  
        $section->addTitle('Отчёт по пользователям', 1);
        
        $table = $section->addTable();
        $table->addRow();
        $table->addCell(500)->addText('ID');
        $table->addCell(2000)->addText('Имя');
        $table->addCell(3000)->addText('Email');
        $table->addCell(1500)->addText('Роль');
        $table->addCell(1500)->addText('Статус');
        $table->addCell(2000)->addText('Дата регистрации');
        
        foreach ($data as $item) {
            $table->addRow();
            $table->addCell(500)->addText($item['id']);
            $table->addCell(2000)->addText($item['name']);
            $table->addCell(3000)->addText($item['email']);
            $table->addCell(1500)->addText($item['role']);
            $table->addCell(1500)->addText($item['status']);
            $table->addCell(2000)->addText($item['reg_date']);
        }
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment;filename="users_report.docx"');
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output');
        exit;
    }
}
?>