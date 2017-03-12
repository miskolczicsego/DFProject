Hogyan telepítsük az etetőt?
============================

**(a következő lépéseket Ubuntu 16.04 LTS, illetve Raspbian operációs rendszerek alatt végeztem, így előfordulhat hogy más rendszereken nem ezek a parancsok használatosak ugyanezen eredmény eléréséhez. )**

1.Composer telepítése (php csomagkezelő)
----------------------------------------

> **Tetszőleges mappán állva másoljuk a terminálba az alábbi parancsokat:**
>
>   - php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
>   - php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
>   - php composer-setup.php
>   - php -r "unlink('composer-setup.php');
>
> **Az így létrejött composer.phar állományt tegyük globálisan használhatóvá:**
>
> ```mv composer.phar /usr/local/bin/composer```

>    Ezek utána composer parancs bárhonnan használható lesz.




2.nodejs, npm, bower telepítése
-------------------------------

>  **nodejs:**
>
>      sudo apt-get install nodejs-legacy
>
>  **npm**:
>
>
>     sudo apt-get install npm
>
>  **bower**:
>
>      sudo npm install -g bower

3.Git clone
-----------

> Adjuk ki a következp parancsot a git repositoryból való klónozáshoz:

> git clone https://github.com/miskolczicsego/DFProject.git`

4.Telepítsük a függőségeket
---------------------------

> Azon a mappán állva ahová a projektet klónoztuk adjuk ki:
> `composer install`
> Ezek után telepítsük a bootstrapet:
>  `bower install --force bootstrap`

5.Adatbázis konfigurálása:
--------------------------

>  app/config/parameters.yml fájlban beállítjuk az adatbázishoz való
> kapcsolódáshoz szükséges adatokat


6.Telepítsük az adatbázist a következő paranccsal:
--------------------------------------------------

>   php app/console doctrine:schema:update --force

Végezetül indítsuk el a szervert:
---------------------------------

>   php app/console server:run
