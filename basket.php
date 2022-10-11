<?php
declare(strict_types=1);

const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;

$operations = [
    OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
    OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
    OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
    OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
];

$items = [];

function listBuy(array $arr, array $arr2): string
{
//    system('clear');
    system('cls'); // windows
    do {
        if (count($arr)) {
            echo 'Ваш список покупок: ' . PHP_EOL;
            lists();
        } else {
            echo 'Ваш список покупок пуст.' . PHP_EOL;
        }
        echo 'Выберите операцию для выполнения: ' . PHP_EOL;
        // Проверить, есть ли товары в списке? Если нет, то не отображать пункт про удаление товаров
        echo implode(PHP_EOL, $arr2) . PHP_EOL . '> ';
        $operationNumber = trim(fgets(STDIN));

        if (!array_key_exists($operationNumber, $arr2)) {
            system('cls');
            echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
        }
    } while (!array_key_exists($operationNumber, $arr2));
    return $operationNumber;
}

function add(): void
{
    global $items;
    echo "Введение название товара для добавления в список: \n> ";
    $itemName = trim(fgets(STDIN));
    $items[] = $itemName;
}

function del(): void
{
    global $items;
    // Проверить, есть ли товары в списке? Если нет, то сказать об этом и попросить ввести другую операцию
    echo 'Текущий список покупок:' . PHP_EOL;
    echo 'Список покупок: ' . PHP_EOL;
    lists();
    echo 'Введение название товара для удаления из списка:' . PHP_EOL . '> ';
    $itemName = trim(fgets(STDIN));

    if (in_array($itemName, $items, true) !== false) {
        while (($key = array_search($itemName, $items, true)) !== false) {
            unset($items[$key]);
        }
    }
}

function prints(): void
{
    global $items;
    echo 'Ваш список покупок: ' . PHP_EOL;
    lists();
    echo 'Всего ' . count($items) . ' позиций. ' . PHP_EOL;
    echo 'Нажмите enter для продолжения';
    fgets(STDIN);
}

function lists(): void
{
    global $items;
    echo implode(PHP_EOL, $items) . PHP_EOL;
}

do {
    $operationNumber = listBuy($items, $operations);

    echo 'Выбрана операция: ' . $operations[$operationNumber] . PHP_EOL;

    switch ($operationNumber) {
        case OPERATION_ADD:
            add();
            break;
        case OPERATION_DELETE:
            del();
            break;
        case OPERATION_PRINT:
            prints();
            break;
    }
    echo "\n ----- \n";
} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;