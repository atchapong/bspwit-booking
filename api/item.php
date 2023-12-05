<?php 
    require_once('database.php');
    class Item extends DataBase {
        public function getAllItem() {
            $sql = "SELECT item.id, item.name, type.name as type_name FROM `item` INNER JOIN `type` ON item.type_id = type.id ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        }

        // public function create($funame, $dstart, $dend, $item_id) {
        //     $sql = "INSERT INTO booking(fullname, date_start, date_start, item_id) VALUES(:funame, :dstart, :dend, :item_id)";
        //     $stmt = $this->database->prepare($sql);
        //     $stmt->execute([
        //         'funame' => $funame,
        //         'dstart' => $dstart,
        //         'dend' => $dend,
        //         'item_id' => $item_id,
        //     ]);
        //     return true
        // }
    }

    // $a = new Booking("a", "b", "c", "d");
    // echo("<script>console.log('PHP: " . $a->name . "');</script>");
?>