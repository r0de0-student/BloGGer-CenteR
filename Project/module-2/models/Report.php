<?php
class Report {
    private $db;
    
    public function __construct($pdo) {
        $this->db = $pdo;
    }
    
    /**
     * Отчёт 1: Пользователи системы
     * Список всех пользователей с ролью, статусом и датой регистрации
     */
    public function getUsersReport() {
        $stmt = $this->db->query("
            SELECT 
                id,
                name,
                email,
                role,
                CASE 
                    WHEN is_blocked = 1 THEN 'Заблокирован'
                    ELSE 'Активен'
                END as status,
                DATE_FORMAT(created_at, '%d.%m.%Y %H:%i') as reg_date
            FROM users 
            ORDER BY id
        ");
        return $stmt->fetchAll();
    }
    
    /**
     * Отчёт 2: Статьи и просмотры
     * Все статьи с автором, блогом, просмотрами и датой публикации
     */
    public function getPostsReport() {
        $stmt = $this->db->query("
            SELECT 
                p.id,
                p.title,
                u.name as author_name,
                b.name as blog_name,
                p.views_count,
                DATE_FORMAT(p.created_at, '%d.%m.%Y') as pub_date
            FROM posts p
            JOIN blogs b ON p.blog_id = b.id
            JOIN users u ON b.user_id = u.id
            ORDER BY p.views_count DESC
        ");
        return $stmt->fetchAll();
    }
    
    /**
     * Отчёт 3: Топ блогов по подписчикам
     * Рейтинг блогов с количеством статей, подписчиков и просмотров
     */
    public function getTopBlogsReport() {
        $stmt = $this->db->query("
            SELECT 
                b.id,
                b.name as blog_name,
                u.name as owner_name,
                COUNT(DISTINCT p.id) as posts_count,
                COUNT(DISTINCT s.subscriber_id) as subscribers_count,
                COALESCE(SUM(p.views_count), 0) as total_views
            FROM blogs b
            JOIN users u ON b.user_id = u.id
            LEFT JOIN posts p ON b.id = p.blog_id
            LEFT JOIN subscriptions s ON b.id = s.blog_id
            GROUP BY b.id
            ORDER BY subscribers_count DESC
            LIMIT 10
        ");
        return $stmt->fetchAll();
    }
    
    /**
     * Отчёт 4: Статистика автора
     * Персональная статистика для авторизованного автора
     */
    public function getAuthorStats($userId) {
        $stmt = $this->db->prepare("
            SELECT 
                COUNT(DISTINCT b.id) as blogs_count,
                COUNT(DISTINCT p.id) as posts_count,
                COALESCE(SUM(p.views_count), 0) as total_views,
                COUNT(DISTINCT c.id) as comments_count,
                COUNT(DISTINCT s.subscriber_id) as subscribers_count
            FROM users u
            LEFT JOIN blogs b ON u.id = b.user_id
            LEFT JOIN posts p ON b.id = p.blog_id
            LEFT JOIN comments c ON p.id = c.post_id
            LEFT JOIN subscriptions s ON b.id = s.blog_id
            WHERE u.id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }
    
    /**
     * Отчёт 5: Активность пользователей (дополнительный)
     * Кто сколько оставил комментариев и статей
     */
    public function getUserActivityReport() {
        $stmt = $this->db->query("
            SELECT 
                u.id,
                u.name,
                u.email,
                u.role,
                COUNT(DISTINCT p.id) as posts_count,
                COUNT(DISTINCT c.id) as comments_count
            FROM users u
            LEFT JOIN blogs b ON u.id = b.user_id
            LEFT JOIN posts p ON b.id = p.blog_id
            LEFT JOIN comments c ON u.id = c.user_id
            GROUP BY u.id
            ORDER BY posts_count DESC, comments_count DESC
        ");
        return $stmt->fetchAll();
    }
    
    /**
     * Отчёт 6: Статистика по дням (дополнительный)
     * Количество регистраций, статей, комментариев по дням
     */
    public function getDailyStatsReport($days = 7) {
        $stmt = $this->db->prepare("
            SELECT 
                DATE(created_at) as date,
                COUNT(*) as registrations
            FROM users
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
            GROUP BY DATE(created_at)
            ORDER BY date DESC
        ");
        $stmt->execute([$days]);
        $users = $stmt->fetchAll();
        
        $stmt2 = $this->db->prepare("
            SELECT 
                DATE(created_at) as date,
                COUNT(*) as posts_count
            FROM posts
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
            GROUP BY DATE(created_at)
            ORDER BY date DESC
        ");
        $stmt2->execute([$days]);
        $posts = $stmt2->fetchAll();
        
        $stmt3 = $this->db->prepare("
            SELECT 
                DATE(created_at) as date,
                COUNT(*) as comments_count
            FROM comments
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
            GROUP BY DATE(created_at)
            ORDER BY date DESC
        ");
        $stmt3->execute([$days]);
        $comments = $stmt3->fetchAll();
        
        return [
            'users' => $users,
            'posts' => $posts,
            'comments' => $comments
        ];
    }
}
?>