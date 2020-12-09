<?php

declare(strict_types=1);

//ЗАДАЧА #1 (ООП)

/**
 * Class Item
 */
final class Item
{
    /**
     * @var array|array[]
     */
    private static array $db = [
        1 => [
            'id' => 1,
            'name' => 'Альфа',
            'status' => 3,
            'changed' => false
        ],
        2 => [
            'id' => 2,
            'name' => 'Бета',
            'status' => 6,
            'changed' => true
        ],
        3 => [
            'id' => 3,
            'name' => 'Гамма',
            'status' => 12,
            'changed' => false
        ],

    ];

    /**
     * id объекта
     * @var int
     */
    private int $id;
    /**
     * Имя объекта
     * @var string
     */
    private string $name;
    /**
     * Статус объекта
     * @var int
     */
    private int $status;
    /**
     * Изменялся ли объект
     * @var bool
     */
    private bool $changed;

    /**
     * Первоначальное состояние объекта
     * @var Item
     */
    private static Item $object;

    /**
     * Конструктор класса Item.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
        $this->init($id);
    }

    /**
     * Инициализация объекта класса (Получение данных из массива в переменной $db)
     * @param int $id
     */
    private function init(int $id)
    {
        foreach (self::$db as $objects => $object) {
            if ($object['id'] === $id) {
                $this->id = $object['id'];
                $this->name = $object['name'];
                $this->status = $object['status'];
                $this->changed = $object['changed'];
            }
        }
        self::$object = clone $this;
    }

    /**
     * Сохраняем объект в базу данных
     */
    public function save()
    {
        if (self::$object != $this) {
            foreach (self::$object as $key => $value) {
                if ($value !== $this->$key) {
                    self::$db[self::$object->id][$key] = $this->$key;
                }
            }
            echo 'Объект сохранён в базе данных <br>';
            self::$db[self::$object->id]['changed'] = true;
        } else {
            echo 'Объект не изменён, сохранение не требуется <br>';
        }
    }

    /**
     * Магический метод __get для получения свойств объекта
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        } else {
            echo 'Свойства ' . $name . ' не существует <br>';
        }
    }


    /**
     * Магический метод __set для изменения свойств объекта
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        switch ($name):
            case 'id':
                echo 'Нельзя менять id объекта <br>';
                break;
            case 'status':
                if (!empty($value) && is_int($value)) {
                    $this->$name = $value;
                    echo 'Свойство ' . $name . ' получило новое значение ' . $value . '<br>';
                } else {
                    echo 'При изменении свойства status произошла ошибка <br>';
                }
                break;
            case 'name':
                if (!empty($value) && is_string($value)) {
                    $this->$name = $value;
                    echo 'Свойство ' . $name . ' получило новое значение ' . $value . '<br>';
                } else {
                    echo 'При изменении свойства name произошла ошибка <br>';
                }
                break;
        endswitch;
    }

    /**
     * Запрет на сериализацию объекта
     */
    private function __wakeup()
    {
    }

    /**
     * Запрет на клонирование объекта
     */
    private function __clone()
    {
    }
}

$item = new Item(3);

echo 'Значение name = ' . $item->name . '<br>';
echo 'Значение status = ' . $item->status . '<br>';
echo 'Значение id = ' . $item->id . '<br>';
echo $item->price;
$item->id = 5;
$item->name = 'Дельта';
$item->status = 77;
$item->save();
