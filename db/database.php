<?php
  class Database {
    private $link;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
      try {
        $config = [
          'database'  => 'planning',
          'username'  => 'root',
          'password'  => '50608173',
          'host'      => 'localhost',
          'charset'   => 'utf8'
        ];

        $dbh = 'mysql:host='.$config['host'].';dbname='.$config['database'].';charset='.$config['charset'];
        $this->link = new PDO($dbh, $config['username'], $config['password']);
      } catch(Exception $e) {
        $explain = 1;
        echo '<div class="error">
                <h1>Error#780'.$explain.'</h1>
                <p>Ошибка при попытке подключится к базе данных.</p>
                <p>Если вы администратор, смотрите решение в документации.</p>
                </div>';
      }
    }

    public function execute($sql) {
        $sth = $this->link->prepare($sql);
        return $sth->execute();
    }

    public function query($sql, $params = null) {
      if(!empty($params) && !is_array($params)) {
        throw new Exception("Параметры должны быть масивом или NULL!");
      }
      if(empty($params)) {
        $params = [];
      }
      $exe = $this->link->prepare($sql);
      $exe->execute($params);

      // if (!is_array($params)) {
      // }
      $result = $exe->fetchAll(PDO::FETCH_ASSOC);
      if($result === false) {
        return ['error' => 'Ошибка выполнения запроса!'];
      }
      return $result;
    }
  }