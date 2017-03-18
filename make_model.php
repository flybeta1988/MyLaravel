<?php

if (count($argv) < 3) {
    exit("how to use ? \n php {$argv[0]} table_name model_name");
}
$table = $argv[1];
$model = $argv[2];
$file = __DIR__ . "/app/Models/{$model}.php";
if (is_file($file)) {
    echo "file exist now ! please back up! i can't rewrite it !文件已存在， 本程序不能覆盖原model， 请备份后再试\n";
    exit;
}
$dns = "mysql:host=localhost;dbname=laravel;charset=utf8;";
$pdo = new PDO($dns, $uname = 'root', $passwd = 'root');
$st = $pdo->query("show full columns from $table");
$fields = $st->fetchAll(PDO::FETCH_ASSOC);
$property = "";

foreach ($fields as $field) {
    $default = '';
    if (!$field['Default'] && !is_numeric($field['Default'])) {
        $default = "''";
    } elseif (is_numeric($field['Default'])) {
        $default = $field['Default'];
    } else {
        $default = "'{$field['Default']}'";
    }

    $property .= "          \$this->attributes['{$field['Field']}'] = {$default};\n";

}

$code = <<<CODE
<?php
namespace App\Models;

class {$model} extends Model
{
    protected \$table = "{$table}";
    
    public function __construct(array \$attributes = [])
    {
{$property}
        parent::__construct(\$attributes);
    }
}

CODE;

file_put_contents($file, $code);
echo "generate laravel model {$model}.php success! \n";
