<?php
require_once 'route/abstract.class.php';

class EnrolmentAPI extends API
{

    final const STATUS = ['not started', 'in progress', 'completed'];

    private function extract_condition() {

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
        return [$condition, $condition_values];
    }

    private function get_record()
    {

        $page = intval($_GET['page'] ?? '0');
        $offset_unit = 20; // 20 rows each page

        [$condition, $condition_values] = $this->extract_condition();

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

    private function get_record_counts()
    {
        [$condition, $condition_values] = $this->extract_condition();
        $sql = "SELECT COUNT(*) as count                     
        FROM Enrolments e 
        JOIN Users u ON e.userID = u.ID
        JOIN Courses c ON e.courseID = c.ID 
        $condition";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($condition_values);
        self::sendResponse($stmt->fetch());
    }

    protected function handleGet()
    {
        $route = substr(explode('?', $_SERVER['REQUEST_URI'])[0], strlen('/api/enrolment/'));
        switch ($route) {
            case '':
                $this->get_record();
                break;
            case 'count':
                $this->get_record_counts();
                break;
            default:
                self::handleError(404, 'Not Found');
                break;
        }
    }

    function generate_enrolments()
    {
        require_once 'route/user.class.php';
        $users = (new UserAPI())->get_all();
        if (!$users) return;
        $user_ids = array_map(function ($user) {
            return $user->ID;
        }, $users);

        require_once 'route/course.class.php';
        $courses = (new CourseAPI())->get_all();
        if (!$courses) return;
        $course_ids = array_map(function ($course) {
            return $course->ID;
        }, $courses);

        $sql = "insert into enrolments (userId, courseID, status) values";
        $values = [];

        for ($i = 0; $i < 100; $i += 1) {
            $random_user_id = array_rand($user_ids);
            $random_course_id = array_rand($course_ids);

            $random_status = array_rand(self::STATUS);

            $sql .= " (:user_$i, :course_$i, :status_$i),";
            $values += [":user_$i" => $user_ids[$random_user_id], ":course_$i" => $course_ids[$random_course_id], ":status_$i" => self::STATUS[$random_status]];
        }

        $stmt = $this->db->prepare(substr($sql, 0, strlen($sql) - 1));
        try {
            $stmt->execute($values);
        } catch (PDOException $e) {
            print_r($values);
        }
    }

    // create new enrolment
    protected function handlePost()
    {
        $this->generate_enrolments();
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
