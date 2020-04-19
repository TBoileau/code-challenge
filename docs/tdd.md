Exemple TDD
===========

[Revenir à la documentation](index.md#test-driven-development)

# Énoncé 

Une compagnie d'assurance automobile propose à ses clients quatre familles de tarifs identifiables par une couleur, du moins au plus onéreux : tarifs bleu, vert, orange et rouge. Le tarif dépend de la situation du conducteur :

* un conducteur de moins de 25 ans et titulaire du permis depuis moins de deux ans, se voit attribuer le tarif rouge, si toutefois il n'a jamais été responsable d'accident. Sinon, la compagnie refuse de l'assurer.
* un conducteur de moins de 25 ans et titulaire du permis depuis plus de deux ans, ou de plus de 25 ans mais titulaire du permis depuis moins de deux ans a le droit au tarif orange s'il n'a jamais provoqué d'accident, au tarif rouge pour un accident, sinon il est refusé.
* un conducteur de plus de 25 ans titulaire du permis depuis plus de deux ans bénéficie du tarif vert s'il n'est à l'origine d'aucun accident et du tarif orange pour un accident, du tarif rouge pour deux accidents, et refusé au-delà
* De plus, pour encourager la fidélité des clients acceptés, la compagnie propose un contrat de la couleur immédiatement la plus avantageuse s'il est entré dans la maison depuis plus de cinq ans. Ainsi, s'il satisfait à cette exigence, un client normalement "vert" devient "bleu", un client normalement "orange" devient "vert", et le "rouge" devient orange.

Ecrire l'algorithme permettant de saisir les données nécessaires (sans contrôle de saisie) et de traiter ce problème. Avant de se lancer à corps perdu dans cet exercice, on pourra réfléchir un peu et s'apercevoir qu'il est plus simple qu'il n'en a l'air (cela s'appelle faire une analyse !)

# Pratique

## Premère étape :

**Problématique :**

**Étant donné** que le conducteur a 20 ans, a eu son permis il y a moins de 2 ans et n'a jamais eu d'accident 

**Quand** je tente détermine son contrat 

**Alors** la couleur du contrat doit être rouge

**Test**
```php
<?php

namespace Domain\Tests;

use Domain\Assurance\UseCase\ChooseContract;
use PHPUnit\Framework\TestCase;

class ChooseContractTest extends TestCase 
{
    private ChooseContract $chooseContract;

    public function setUp(): void
    {
        $this->chooseContract  = new ChooseContract();
    }   

    public function testIfDriveHasLessThan25YearsOldAndLessThan2YearsLicenceObtentionAnd0Accident(): void 
    {
        $this->assertEquals("red", $this->chooseContract->execute(20, 1, 0));
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mon test est censé **échoué** puisque rien n'a été implémenté.

## Deuxième étape

**Code**
```php
<?php

namespace Domain\Assurance\UseCase;

class ChooseContract 
{
    public function execute(int $age, int $yearsOfObtention, int $numberOfAccidents): ?string 
    {
        return "red";
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mon test est passé au **vert** puisque `red` est bien retourné par la méthode `execute`.

**Observation**
Que remarquez-vous ? Nous n'avons implémenté aucun algorithme, aucun `if`, nous avons écrit le minimum de code pour que notre test passe au **vert**.

## Troisième étape

**Problématique :**

**Étant donné** que le conducteur a 20 ans, a eu son permis il y a moins de 2 ans et a causé un accident 

**Quand** je tente détermine son contrat 

**Alors** je ne suis pas censé recevoir de contrat

**Test**
```php
<?php

namespace Domain\Tests;

use Domain\Assurance\UseCase\ChooseContract;
use PHPUnit\Framework\TestCase;

class ChooseContractTest extends TestCase 
{
    /** ...setUp et  précédents tests */

    public function testIfDriveHasLessThan25YearsOldAndLessThan2YearsLicenceObtentionAnd1Accident(): void 
    {
        $this->assertEquals(null, $this->chooseContract->execute(20, 1, 1));
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mon test est censé **échoué** puisque rien n'a été implémenté.

## Quatrième étape 

**Code**
```php
<?php

namespace Domain\Assurance\UseCase;

class ChooseContract 
{
    public function execute(int $age, int $yearsOfObtention, int $numberOfAccidents): ?string 
    {
        if ($numberOfAccidents > 0) {
            return null; 
        }              
        return "red";
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mes tests sont passés au **vert**.

## Cinquième étape

**Problématique :**

**Étant donné** que le conducteur a 20 ans, a eu son permis il y a plus de 2 ans et n'a causé aucun accident 

**Quand** je tente détermine son contrat 

**Alors** la couleur du contrat doit être orange

**Test**
```php
<?php

namespace Domain\Tests;

use Domain\Assurance\UseCase\ChooseContract;
use PHPUnit\Framework\TestCase;

class ChooseContractTest extends TestCase 
{
    /** ...setUp et  précédents tests */

    public function testIfDriveHasLessThan25YearsOldAndMoreThan2YearsLicenceObtentionAnd0Accident(): void 
    {
        $this->assertEquals("orange", $this->chooseContract->execute(20, 3, 0));
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mon test est censé **échoué** puisque rien n'a été implémenté.

## Sixième étape

**Code**
```php
<?php

namespace Domain\Assurance\UseCase;

class ChooseContract 
{
    public function execute(int $age, int $yearsOfObtention, int $numberOfAccidents): ?string 
    {
        if ($numberOfAccidents > 0) {
            return null; 
        }      
        
        if ($yearsOfObtention >= 2) {
            return "orange";
        }
        
        return "red";
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mes tests sont passés au **vert**.

## Septième étape

**Problématique :**

**Étant donné** que le conducteur a 30 ans, a eu son permis il y a moins de 2 ans et n'a causé aucun accident 

**Quand** je tente détermine son contrat 

**Alors** la couleur du contrat doit être orange

**Test**
```php
<?php

namespace Domain\Tests;

use Domain\Assurance\UseCase\ChooseContract;
use PHPUnit\Framework\TestCase;

class ChooseContractTest extends TestCase 
{
    /** ...setUp et  précédents tests */

    public function testIfDriveHasMoreThan25YearsOldAndLessThan2YearsLicenceObtentionAnd0Accident(): void 
    {
        $this->assertEquals("orange", $this->chooseContract->execute(30, 1, 0));
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mon test est censé **échoué** puisque rien n'a été implémenté.

## Huitième étape

**Code**
```php
<?php

namespace Domain\Assurance\UseCase;

class ChooseContract 
{
    public function execute(int $age, int $yearsOfObtention, int $numberOfAccidents): ?string 
    {
        if ($numberOfAccidents > 0) {
            return null; 
        }      
        
        if (($age < 25 && $yearsOfObtention >= 2) || ($age >= 25 && $yearsOfObtention < 2)) {
            return "orange";
        }
        
        return "red";
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mes tests sont passés au **vert**.

## Neuvième étape

**Problématique :**

**Étant donné** que le conducteur a 20 ans, a eu son permis il y a plus de 2 ans et a causé un accident 

**Quand** je tente détermine son contrat 

**Alors** la couleur du contrat doit être rouge

**Test**
```php
<?php

namespace Domain\Tests;

use Domain\Assurance\UseCase\ChooseContract;
use PHPUnit\Framework\TestCase;

class ChooseContractTest extends TestCase 
{
    /** ...setUp et  précédents tests */

    public function testIfDriveHasLessThan25YearsOldAndMoreThan2YearsLicenceObtentionAnd1Accident(): void 
    {
        $this->assertEquals("red", $this->chooseContract->execute(20, 3, 1));
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mon test est censé **échoué** puisque rien n'a été implémenté.

## Dixième étape

**Code**
```php
<?php

namespace Domain\Assurance\UseCase;

class ChooseContract 
{
    public function execute(int $age, int $yearsOfObtention, int $numberOfAccidents): ?string 
    {        
        if ($age < 25 && $yearsOfObtention >= 2 && $numberOfAccidents === 1) {
            return "red"; 
        }   

        if (($age < 25 && $yearsOfObtention >= 2) || ($age >= 25 && $yearsOfObtention < 2)) {
            return "orange";
           
        }
        
        if ($numberOfAccidents > 0) {
            return null; 
        }      

        return "red";
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mes tests sont passés au **vert**.

## Onzième étape

**Problématique :**

**Étant donné** que le conducteur a 30 ans, a eu son permis il y a plus de 2 ans et a causé un accident 

**Quand** je tente détermine son contrat 

**Alors** la couleur du contrat doit être rouge

**Test**
```php
<?php

namespace Domain\Tests;

use Domain\Assurance\UseCase\ChooseContract;
use PHPUnit\Framework\TestCase;

class ChooseContractTest extends TestCase 
{
    /** ...setUp et  précédents tests */

    public function testIfDriveHasMoreThan25YearsOldAndLessThan2YearsLicenceObtentionAnd1Accident(): void 
    {
        $this->assertEquals("red", $this->chooseContract->execute(30, 3, 1));
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mon test est censé **échoué** puisque rien n'a été implémenté.

## Douxième étape

**Code**
```php
<?php

namespace Domain\Assurance\UseCase;

class ChooseContract 
{
    public function execute(int $age, int $yearsOfObtention, int $numberOfAccidents): ?string 
    {        
        if ($age < 25 && $yearsOfObtention >= 2 && $numberOfAccidents === 1) {
            return "red"; 
        }   

        if ($age >= 25 && $yearsOfObtention > 2 && $numberOfAccidents === 1) {
            return "red"; 
        }   

        if (($age < 25 && $yearsOfObtention >= 2) || ($age >= 25 && $yearsOfObtention < 2)) {
            return "orange";
           
        }
        
        if ($numberOfAccidents > 0) {
            return null; 
        }      

        return "red";
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mes tests sont passés au **vert**.

## Treizième étape - REFACTORING

**Code**
```php
<?php

namespace Domain\Assurance\UseCase;

class ChooseContract 
{
    public function execute(int $age, int $yearsOfObtention, int $numberOfAccidents): ?string 
    {        
        if ((($age < 25 && $yearsOfObtention >= 2) || ($age >= 25 && $yearsOfObtention < 2)) && $numberOfAccidents <= 1) {
            if ($numberOfAccidents === 1) {
                return "red"; 
            } 

            return "orange";
        }
        
        if ($numberOfAccidents > 0) {
            return null; 
        }      

        return "red";
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mes tests sont passés au **vert**.

## Quatorzième étape

**Problématique :**

**Étant donné** que le conducteur a 30 ans, a eu son permis il y a plus de 2 ans et n'a causé aucun accident 

**Quand** je tente détermine son contrat 

**Alors** la couleur du contrat doit être verte

**Test**
```php
<?php

namespace Domain\Tests;

use Domain\Assurance\UseCase\ChooseContract;
use PHPUnit\Framework\TestCase;

class ChooseContractTest extends TestCase 
{
    /** ...setUp et  précédents tests */

    public function testIfDriveHasMoreThan25YearsOldAndMoreThan2YearsLicenceObtentionAnd0Accident(): void 
    {
        $this->assertEquals("green", $this->chooseContract->execute(30, 3, 0));
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mon test est censé **échoué** puisque rien n'a été implémenté.

## Quinzième étape

**Code**
```php
<?php

namespace Domain\Assurance\UseCase;

class ChooseContract 
{
    public function execute(int $age, int $yearsOfObtention, int $numberOfAccidents): ?string 
    {        
        if ($age >= 25 && $yearsOfObtention >= 2 && $numberOfAccidents === 0) {
            return "green";
        }

        if ((($age < 25 && $yearsOfObtention >= 2) || ($age >= 25 && $yearsOfObtention < 2)) && $numberOfAccidents <= 1) {
            if ($numberOfAccidents === 1) {
                return "red"; 
            } 

            return "orange";
        }
        
        if ($numberOfAccidents > 0) {
            return null; 
        }      

        return "red";
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mes tests sont passés au **vert**.

## Seizième étape

**Problématique :**

**Étant donné** que le conducteur a 30 ans, a eu son permis il y a plus de 2 ans et a causé 1 accident 

**Quand** je tente détermine son contrat 

**Alors** la couleur du contrat doit être orange

**Test**
```php
<?php

namespace Domain\Tests;

use Domain\Assurance\UseCase\ChooseContract;
use PHPUnit\Framework\TestCase;

class ChooseContractTest extends TestCase 
{
    /** ...setUp et  précédents tests */

    public function testIfDriveHasMoreThan25YearsOldAndMoreThan2YearsLicenceObtentionAnd1Accident(): void 
    {
        $this->assertEquals("orange", $this->chooseContract->execute(30, 3, 1));
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mon test est censé **échoué** puisque rien n'a été implémenté.

## Dix-septième étape

**Code**
```php
<?php

namespace Domain\Assurance\UseCase;

class ChooseContract 
{
    public function execute(int $age, int $yearsOfObtention, int $numberOfAccidents): ?string 
    {        
        if ($age >= 25 && $yearsOfObtention >= 2 && $numberOfAccidents === 0) {
            return "green";
        }

        if ($age >= 25 && $yearsOfObtention >= 2 && $numberOfAccidents === 1) {
            return "orange";
        }

        if ((($age < 25 && $yearsOfObtention >= 2) || ($age >= 25 && $yearsOfObtention < 2)) && $numberOfAccidents <= 1) {
            if ($numberOfAccidents === 1) {
                return "red"; 
            } 

            return "orange";
        }
        
        if ($numberOfAccidents > 0) {
            return null; 
        }      

        return "red";
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mes tests sont passés au **vert**.

## Dix-huitième étape - REFACTORING

**Code**
```php
<?php

namespace Domain\Assurance\UseCase;

class ChooseContract 
{
    public function execute(int $age, int $yearsOfObtention, int $numberOfAccidents): ?string 
    {        
        if ($age >= 25 && $yearsOfObtention >= 2 && $numberOfAccidents === 0) {
            if ($numberOfAccidents === 0) {
                return "green";
            }

            return "orange";
        }

        if ((($age < 25 && $yearsOfObtention >= 2) || ($age >= 25 && $yearsOfObtention < 2)) && $numberOfAccidents <= 1) {
            if ($numberOfAccidents === 1) {
                return "red"; 
            } 

            return "orange";
        }
        
        if ($numberOfAccidents > 0) {
            return null; 
        }      

        return "red";
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mes tests sont passés au **vert**.

## Dix-neuvième étape

**Problématique :**

**Étant donné** que le conducteur a 30 ans, a eu son permis il y a plus de 2 ans et a causé 2 accidents 

**Quand** je tente détermine son contrat 

**Alors** la couleur du contrat doit être rouge

**Test**
```php
<?php

namespace Domain\Tests;

use Domain\Assurance\UseCase\ChooseContract;
use PHPUnit\Framework\TestCase;

class ChooseContractTest extends TestCase 
{
    /** ...setUp et  précédents tests */

    public function testIfDriveHasMoreThan25YearsOldAndMoreThan2YearsLicenceObtentionAnd2Accidents(): void 
    {
        $this->assertEquals("red", $this->chooseContract->execute(30, 3, 2));
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mon test est censé **échoué** puisque rien n'a été implémenté.

## Vingtième étape

**Code**
```php
<?php

namespace Domain\Assurance\UseCase;

class ChooseContract 
{
    public function execute(int $age, int $yearsOfObtention, int $numberOfAccidents): ?string 
    {        
        if ($age >= 25 && $yearsOfObtention >= 2 && $numberOfAccidents === 0) {
            if ($numberOfAccidents === 0) {
                return "green";
            } 
            if ($numberOfAccidents === 2) {
                return "red";
            } 

            return "orange";
        }

        if ((($age < 25 && $yearsOfObtention >= 2) || ($age >= 25 && $yearsOfObtention < 2)) && $numberOfAccidents <= 1) {
            if ($numberOfAccidents === 1) {
                return "red"; 
            } 

            return "orange";
        }
        
        if ($numberOfAccidents > 0) {
            return null; 
        }      

        return "red";
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mes tests sont passés au **vert**.

## Vingt-et-unième étape

**Problématique :**

**Étant donné** que le conducteur a 30 ans, a eu son permis il y a plus de 2 ans, a plus de 5 ans d'anciènneté, et son tarif actuel est vert

**Quand** je tente détermine son contrat 

**Alors** la couleur du contrat doit être bleu

**Test**
```php
<?php

namespace Domain\Tests;

use Domain\Assurance\UseCase\ChooseContract;
use PHPUnit\Framework\TestCase;

class ChooseContractTest extends TestCase 
{
    /** ...setUp et  précédents tests */

    public function testIfDriveHasMoreThan25YearsOldAndMoreThan2YearsLicenceObtentionAnd0AccidentAndMoreThan5YearsOfSeniorityAndGreenContract(): void 
    {
        $this->assertEquals("bleu", $this->chooseContract->execute(30, 3, 0, "green"));
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mon test est censé **échoué** puisque rien n'a été implémenté.

## Vingt-deuxième étape

**Code**
```php
<?php

namespace Domain\Assurance\UseCase;

class ChooseContract 
{
    public function execute(int $age, int $yearsOfObtention, int $numberOfAccidents, ?string $color = null): ?string 
    {       
        if ($color === "green") {
            return "blue";
        }   

        if ($age >= 25 && $yearsOfObtention >= 2 && $numberOfAccidents === 0) {
            if ($numberOfAccidents === 0) {
                return "green";
            } 
            if ($numberOfAccidents === 2) {
                return "red";
            } 

            return "orange";
        }

        if ((($age < 25 && $yearsOfObtention >= 2) || ($age >= 25 && $yearsOfObtention < 2)) && $numberOfAccidents <= 1) {
            if ($numberOfAccidents === 1) {
                return "red"; 
            } 

            return "orange";
        }
        
        if ($numberOfAccidents > 0) {
            return null; 
        }      

        return "red";
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mes tests sont passés au **vert**.

## Vingt-troisième étape

**Problématique :**

**Étant donné** que le conducteur a 30 ans, a eu son permis il y a plus de 2 ans, a plus de 5 ans d'anciènneté, et son tarif actuel est orange

**Quand** je tente détermine son contrat 

**Alors** la couleur du contrat doit être vert

**Test**
```php
<?php

namespace Domain\Tests;

use Domain\Assurance\UseCase\ChooseContract;
use PHPUnit\Framework\TestCase;

class ChooseContractTest extends TestCase 
{
    /** ...setUp et  précédents tests */

    public function testIfDriveHasMoreThan25YearsOldAndMoreThan2YearsLicenceObtentionAnd0AccidentAndMoreThan5YearsOfSeniorityAndOrangeContract(): void 
    {
        $this->assertEquals("green", $this->chooseContract->execute(30, 3, 0, 6));
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mon test est censé **échoué** puisque rien n'a été implémenté.

## Vingt-quatrième étape

**Code**
```php
<?php

namespace Domain\Assurance\UseCase;

class ChooseContract 
{
    public function execute(int $age, int $yearsOfObtention, int $numberOfAccidents, ?string $color = null): ?string 
    {        
        if ($color === "green") {
            return "blue";
        }   

        if ($color === "orange") {
            return "green";
        }   
        
        if ($age >= 25 && $yearsOfObtention >= 2 && $numberOfAccidents === 0) {
            if ($numberOfAccidents === 0) {
                return "green";
            } 
            if ($numberOfAccidents === 2) {
                return "red";
            } 

            return "orange";
        }

        if ((($age < 25 && $yearsOfObtention >= 2) || ($age >= 25 && $yearsOfObtention < 2)) && $numberOfAccidents <= 1) {
            if ($numberOfAccidents === 1) {
                return "red"; 
            } 

            return "orange";
        }
        
        if ($numberOfAccidents > 0) {
            return null; 
        }      

        return "red";
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mes tests sont passés au **vert**.

## Dernière étape - REFACTORING

*Note : je vous passe le changement de couleur pour chacune d'entre elle, passons au refactoring.*

**Code**
```php
<?php

namespace Domain\Assurance\UseCase;

interface Contract 
{
    public function isAllowed(int $age, int $yearsOfObtention, int $numberOfAccidents, ?string $color = null): bool;
}

class BlueContract implements Contract
{
    const COLOR = "blue";

    public function isAllowed(int $age, int $yearsOfObtention, int $numberOfAccidents, ?string $color = null): bool
    {        
        return $color === "green";
    }
}

class GreenContract implements Contract
{
    const COLOR = "green";

    public function isAllowed(int $age, int $yearsOfObtention, int $numberOfAccidents, ?string $color = null): bool
    {        
        return $color === "orange" || ($age >= 25 && $yearsOfObtention >= 2 && $numberOfAccidents === 0);
    }
}

class OrangeContract implements Contract
{
    const COLOR = "orange";

    public function isAllowed(int $age, int $yearsOfObtention, int $numberOfAccidents, ?string $color = null): bool
    {        
        return $color === "red" 
            || (
                $age >= 25 
                && (
                    ($yearsOfObtention >= 2 && $numberOfAccidents === 2) 
                    || ($yearsOfObtention < 2 && $numberOfAccidents === 1)
                )
            )
        ;
    }
}

class RedContract implements Contract
{
    const COLOR = "red";

    public function isAllowed(int $age, int $yearsOfObtention, int $numberOfAccidents, ?string $color = null): bool
    {        
        return $color === "red" 
            || (
                $age >= 25 
                && (
                    ($yearsOfObtention >= 2 && $numberOfAccidents === 1) 
                    || ($yearsOfObtention < 2 && $numberOfAccidents === 0)
                )
            )
        ;
    }
}

class ContractChoice 
{
    private array $contracts;
    
    public function __construct()
    {
        $this->contracts = [
            new BlueContract(),
            new GreenContract(),
            new OrangeContract(),
            new RedContract(),
        ];
    }
    
    public function choose(int $age, int $yearsOfObtention, int $numberOfAccidents, ?string $color = null): ?Contract 
    {
        foreach ($this->contracts as $contract) {
            if ($contract->isAllowed($age, $yearsOfObtention, $numberOfAccidents, $color)) {
                return $contract;
            }
        }
        
        return null;
    }
}


class ChooseContract 
{
    private ContractChoice $contractChoice;
    
    public function __construct(ContractChoice $contractChoice)
    {
        $this->contractChoice = $contractChoice;
    }

    public function execute(int $age, int $yearsOfObtention, int $numberOfAccidents, ?string $color = null): ?string 
    {        
        $contract = $this->contractChoice->choose($age, $yearsOfObtention, $numberOfAccidents, $color);

        return $contract === null ? null : $contract::COLOR;
    }
}
```

**Je lance mon test :** 
```
bin/phpunit domain/tests/ChooseContractTest.php
```

Mes tests sont passés au **vert**.
