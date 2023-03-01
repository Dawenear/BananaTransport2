Ladies and gentlemans i proudly present you:

# Banana Transport 2.0

## Original task:
Write a PHP implementation that can accept any set of delivery notes and produce a list of records detailing every step of the journey in the order they were visited.  
Script must be supplied with unbroken chain without loops.

## Origin
A long time ago in a galaxy far far away on a job appliance I got a task to create PHP script described above.  
I made a solution and that's the end of the story... or not ?  
After 4 years I got hands on this solution and got an idea if I can beat myself after all those years (and test a few stuff in PHP).  
So I made this simple testing environment where I can test a few more solutions at once to see what is fast and what is not.  
Disclaimer: this is definitely not a proper way how to test PHP code but for me it is enough

## How to install
1. git pull
2. composer install

## How to use
Currently only terminal use is available as I'm lazy to take care of that five lines of HTML
1. go to root
2. use `php index.php <path>`. Replace `<path>` witn filepath to the delivery notes
    1. for example `php index.php 'route.json'`
3. Hope for the best