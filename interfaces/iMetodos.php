<?php
interface iMetodos{

    public function insert($values);
    public function getAll();
    public function getById($id);
    public function update($values);
    public function delete($id);
}
?>