# NK ULTRA's Shitty Synth 2000

This website features a pretty bare synth coded with JavaScript and Web Audio API (the whole thing being run by Symfony). It is playable using the keys of your keyboard or by simply clicking on each key (touch works on mobile).

It isn't a good synth nor does it work without issues. The main ones being that *click* sound happening at the end of each tone or the inability to play multiple tones at once or to switch from one key to another efficiently.

Please keep in mind that it's been developed in less than three days and is very, very much a WIP.

## Things to do to make it work:
1. Clone this repo wherever you like
2. composer install
3. yarn install
4. create a .env.local with your db information
5. symfony console doctrine:database:create
6. symfony console doctrine:migration:migrate
7. symfony console doctrine:fixtures:load
8. symfony serve
9. yarn encore dev-server (there's a bug with yarn encore dev)
10. That's it I guess!
