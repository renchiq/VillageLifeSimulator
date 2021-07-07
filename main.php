<?php

interface Animal
{
    public function getIdentifier(): int;

    public function giveProducts(): array;
}

class Cow implements Animal
{
    private int $identifier;

    public function __construct()
    {
        static $identifier = 0;
        $this->identifier = $identifier + 1;
    }

    public function getIdentifier(): int
    {
        return $this->identifier;
    }

    public function giveProducts(): array
    {
        return ["Milk", rand(8, 12)];
    }
}

class Chicken implements Animal
{
    private int $identifier;

    public function __construct()
    {
        static $counter = 0;
        $this->identifier = $counter++;
    }

    public function getIdentifier(): int
    {
        return $this->identifier;
    }

    public function giveProducts(): array
    {
        return ["Eggs", rand(0, 1)];
    }
}

class Farm
{
    private array $animalsList = [];
    private array $productsList = [];

    public function getAnimalsList(): array
    {
        $animalsCount = [];
        foreach ($this->animalsList as $animal) {
            if (isset($animalsCount[get_class($animal)])) {
                $animalsCount[get_class($animal)] += 1;
            } else {
                $animalsCount[get_class($animal)] = 1;
            }
        }
        return $animalsCount;
    }

    public function getProductsList(): array
    {
        return $this->productsList;
    }

    public function addAnimal($animal): void
    {
        $animalType = get_class($animal);
        $this->animalsList[] = new $animalType;
    }

    public function collectProducts(): void
    {
        foreach ($this->animalsList as $animal) {
            $products = $animal->giveProducts();
            if (isset($this->productsList[$products[0]])) {
                $this->productsList[$products[0]] += $products[1];
            } else {
                $this->productsList[$products[0]] = $products[1];
            }
        }
    }
}

$farmExample = new Farm;

// Система должна добавить животных в хлев (10 коров и 20 кур).
for ($i = 0; $i < 10; $i++) {
    $farmExample->addAnimal(new Cow);
}

for ($i = 0; $i < 20; $i++) {
    $farmExample->addAnimal(new Chicken);
}

// Вывести на экран информацию о количестве каждого типа животных на ферме.
foreach ($farmExample->getAnimalsList() as $animalType => $count) {
    echo "Kind of animal: $animalType. Count: $count.<br>";
}

// 7 раз (неделю) произвести сбор продукции (подоить коров и собрать яйца у кур).
for ($i = 0; $i < 7; $i++) {
    $farmExample->collectProducts();
}

// Вывести на экран общее кол-во собранных за неделю шт. яиц и литров молока.
foreach ($farmExample->getProductsList() as $productType => $count) {
    echo "Product type: $productType. Count: $count.<br>";
}

// Добавить на ферму ещё 5 кур и 1 корову (съездили на рынок, купили животных).
for ($i = 0; $i < 5; $i++) {
    $farmExample->addAnimal(new Chicken);
}
$farmExample->addAnimal(new Cow);

// Снова вывести информацию о количестве каждого типа животных на ферме.
foreach ($farmExample->getAnimalsList() as $animalType => $count) {
    echo "Kind of animal: $animalType. Count: $count.<br>";
}

// Снова 7 раз (неделю) производим сбор продукции и выводим результат на экран.
for ($i = 0; $i < 7; $i++) {
    $farmExample->collectProducts();
}
foreach ($farmExample->getProductsList() as $productType => $count) {
    echo "Product type: $productType. Count: $count.<br>";
}