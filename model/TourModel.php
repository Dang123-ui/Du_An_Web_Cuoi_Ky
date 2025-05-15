<?php
require_once 'database.php';

class TourModel
{
    private function buildWhereClause($loaiTour)
    {
        if ($loaiTour === 'all') {
            return '';
        }
        return 'WHERE loaiTour = ?';
    }

    private function buildOrderByClause($sortBy, $order)
    {
        $validSortBy = ['price', 'ngaymotour', 'discount'];
        $validOrder = ['ASC', 'DESC'];

        $sortBy = in_array(strtolower($sortBy), $validSortBy) ? strtolower($sortBy) : 'ngaymotour';
        $order = in_array(strtoupper($order), $validOrder) ? strtoupper($order) : 'DESC';

        return "ORDER BY $sortBy $order";
    }

    public function getToursByPage($page, $perPage, $loaiTour = 'all')
    {
        $offset = (int) (max(0, ($page - 1) * $perPage));
        $perPage = max(1, (int) $perPage);

        $whereClause = $this->buildWhereClause($loaiTour);
        $sql = "SELECT * FROM tour " . ($whereClause ?: '') . " ORDER BY ngayMoTour DESC LIMIT $perPage OFFSET $offset";

        if ($loaiTour === 'all') {
            return pdo_query($sql);
        } else {
            return pdo_query($sql, $loaiTour);
        }
    }

    public function getTotalTours($loaiTour = 'all')
    {
        $whereClause = $this->buildWhereClause($loaiTour);
        $sql = "SELECT COUNT(*) FROM tour " . ($whereClause ?: '');

        if ($loaiTour === 'all') {
            return pdo_query_value($sql);
        } else {
            return pdo_query_value($sql, $loaiTour);
        }
    }

    public function getFeaturedTours($limit, $type)
    {
        $limit = (int) $limit; // Ensure $limit is an integer
        $sql = "SELECT * FROM tour WHERE loaiTour = ? ORDER BY RAND() LIMIT {$limit}";
        try {
            return pdo_query($sql, $type);
        } catch (PDOException $e) {
            throw new Exception("Error getting featured tours: " . $e->getMessage());
        }
    }

    public function searchTours($keyword, $loaiTour = 'all')
    {
        $whereClause = $this->buildWhereClause($loaiTour);

        $keyword = "%$keyword%";
        if ($whereClause === '') {
            $sql = "SELECT * FROM tour WHERE (tenTour LIKE ? OR tuyenDi LIKE ? OR category LIKE ?) ORDER BY ngayMoTour DESC";
            return pdo_query($sql, $keyword, $keyword, $keyword);
        } else {
            $sql = "SELECT * FROM tour $whereClause AND (tenTour LIKE ? OR tuyenDi LIKE ? OR category LIKE ?) ORDER BY ngayMoTour DESC";
            return pdo_query($sql, $loaiTour, $keyword, $keyword, $keyword);
        }
    }

    public function getToursByPageSorted($page, $perPage, $sortBy, $order = 'DESC', $loaiTour = 'all')
    {
        $offset = (int) (max(0, ($page - 1) * $perPage));
        $perPage = max(1, (int) $perPage);
        $whereClause = $this->buildWhereClause($loaiTour);
        $orderByClause = $this->buildOrderByClause($sortBy, $order);
        $sql = "SELECT * FROM tour " . ($whereClause ?: '') . " $orderByClause LIMIT $perPage OFFSET $offset";

        if ($loaiTour === 'all') {
            return pdo_query($sql);
        } else {
            return pdo_query($sql, $loaiTour);
        }
    }
}
?>