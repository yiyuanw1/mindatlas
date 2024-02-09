<?php
require 'route/abstract.class.php';

class EnrolmentAPI extends API
{
    protected function handleGet()
    {
        $page = intval($_GET['page'] ?? '1') - 1;
        $offset_unit = 20; // 20 rows each page

        $condition = "";
        $condition_values = array();
        if (isset($_GET['filter'])) {
            $filter = $_GET['filter'];
            foreach (explode('&', $filter) as $chunk) {
                if ($condition != '') $condition .= ' AND ';
                $param = explode('=', $chunk);
                $condition .= "{$param[0]}ID=:{$param[0]}";
                $condition_values[":{$param[0]}"] = intval($param[1]);
            }
        }

        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            if ($condition != '') $condition .= ' AND ';
            $search_array = [];
            foreach (['firstname', 'surname', 'title', 'description'] as $index => $column) {
                $search_array[] = "$column LIKE :search_$index";
                $condition_values[":search_$index"] = "%$search%";
            }
            $condition .= '(' . implode(' OR ', $search_array) . ')';
        }

        if ($condition != '') $condition = 'WHERE ' . $condition;
        $sql = "SELECT e.ID, firstname, surname, title, description, status
                    FROM Enrolments e 
                    JOIN Users u ON e.userID = u.ID
                    JOIN Courses c ON e.courseID = c.ID
                    $condition
                    LIMIT :rows
                    OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':rows' => $offset_unit,
            ':offset' => $offset_unit * $page
        ] + $condition_values);
        self::sendResponse($stmt->fetchAll());
    }

    // create new enrolment
    protected function handlePost()
    {
    }

    protected function handleDelete()
    {
    }

    protected function handlePut()
    {
    }

}

$method = $_SERVER['REQUEST_METHOD'];
$api = new EnrolmentAPI();
$api->handle($method);
?>