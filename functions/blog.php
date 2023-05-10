<?php
function blogAdd(PDO $connect, array $data)
{
    try {
        $sql = "INSERT INTO `blogs` ( `author_id`, `title`, `content`, `image`) VALUES( :author_id, :title, :content, :image)";
        $statement = $connect->prepare($sql);
        $statement->execute($data);
        return $connect->lastInsertId();
    } catch (PDOException $e) {
        logger(serialize($e->getMessage()), 'error.txt',false);
        return false;
    }
}

function getAllBlogs(PDO $connect, $perPage = false, $offset = false)
{
    try {
        $query = "SELECT * FROM `blogs`";
        if ($perPage !== false && $offset !== false) {
            $query .= "LIMIT $offset, $perPage";
        }
        $stmt = $connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        logger(serialize($e->getMessage()), 'error.txt',false);

        return false;
    }
}

function countBlogs(PDO $connect): int
{
    try {
        $query = "SELECT count(`id`) as counter FROM `blogs`";
        $stmt = $connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        logger(serialize($e->getMessage()),'error.txt', false);
        return false;
    }
}