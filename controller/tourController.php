<?php
require_once 'model/TourModel.php';
class TourController
{
    private $tourModel;
    public function __construct()
    {
        $this->tourModel = new TourModel();
    }
    public function index()
    {
        $perPage = 20;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $page = max(1, $page);
        $sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'ngaymotour';
        $order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
        $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
        $loaiTour = isset($_GET['type']) ? $_GET['type'] : 'all';
        if (!in_array($loaiTour, ['all', 'tour-trong-nuoc', 'tour-nuoc-ngoai'])) {
            $loaiTour = 'all';
        }
        if (!empty($keyword)) {
            $tours = $this->tourModel->searchTours($keyword, $loaiTour);
            $totalTours = count($tours);
            $totalPages = 1; // Tạm thời không phân trang cho tìm kiếm
        } else {
            $tours = $this->tourModel->getToursByPageSorted($page, $perPage, $sortBy, $order, $loaiTour);
            $totalTours = (int) $this->tourModel->getTotalTours($loaiTour);
            ;
            $perPage = (int) $perPage ?: 1;
            $totalPages = ceil($totalTours / $perPage);
        }

        $featuredTours = $this->tourModel->getFeaturedTours(5, $loaiTour);

        return [
            'tours' => $tours,
            'featuredTours' => $featuredTours,
            'page' => $page,
            'totalPages' => $totalPages
        ];
    }
    public function search()
    {
        $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
        $loaiTour = isset($_GET['type']) ? $_GET['type'] : 'all';
        if (!in_array($loaiTour, ['all', 'tour-trong-nuoc', 'tour-nuoc-ngoai'])) {
            $loaiTour = 'all';
        }
        if (!empty($keyword)) {
            header('Location: ../controllers/TourController.php');
            exit;
        }
        $tours = $this->tourModel->searchTours($keyword, $loaiTour);
        $totalTours = (int) count($tours); // Ép kiểu thành số nguyên
        $totalPages = 1;
        $featuredTours = $this->tourModel->getFeaturedTours(5, $loaiTour);

        require_once '../view/tourList.php';
    }
    public function sort()
    {
        $perPage = 20; // Đảm bảo $perPage là số nguyên
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $page = max(1, $page);

        $sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'ngaymotour';
        $order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
        $loaiTour = isset($_GET['type']) ? $_GET['type'] : 'all';

        $tours = $this->tourModel->getToursByPageSorted($page, $perPage, $sortBy, $order, $loaiTour);
        $totalTours = (int) $this->tourModel->getTotalTours($loaiTour); // Ép kiểu thành số nguyên
        $perPage = (int) $perPage ?: 1; // Đảm bảo không chia cho 0
        $totalPages = ceil($totalTours / $perPage);
        $featuredTours = $this->tourModel->getFeaturedTours(5, $loaiTour);

        require_once '../view/tourList.php';
    }


}
?>