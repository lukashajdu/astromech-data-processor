Astromech Data Processor (ADP)
===

## Installation

1. Clone the APD repository
    ```
    $ git clone git@github.com:lukashajdu/astromech-data-processor.git
    $ cd astromech-data-processor
    ```
1. Install the project
    ```
    ./bin/astromech.sh build
    ```
    The command will create a Docker image with all necessary dependencies.


The ADP contains shell script to automate some tasks and simplify usage.
Run the following script to get list of commands:

``` 
$ ./bin/astromech.sh
Usage: ./bin/astromech.sh build|help|phpunit|run-decoder|sh
```

Please refer to `/tests` folder for the code usage.


## Tests

Run unit tests with the following command:

``` 
./bin/astromech.sh phpunit --testdox
```

## Processing data

To make a communication with the application easier, a simple interface was created.
The interface expects JSON data in the body of a POST request and it prints the processed
data or error message.

The following script will run PHP build in server inside the Docker image
and expose it on the local port *8000*.

```
$ ./bin/astromech.sh run-decoder
PHP 7.2.11 Development Server started at Tue Nov  6 23:24:04 2018
Listening on http://0.0.0.0:8000
Document root is /astromech-data-processor/public
Press Ctrl-C to quit.
```

Running application can be tested with the following example request:

```
curl \
    -X POST \
    -d '{"message": "01010100 01101000 01100001 01101110 01101011 01110011 00100000 01100110 01101111 01110010 00100000 01110100 01101000 01100101 00100000 01101001 01101110 01110100 01100101 01110010 01100101 01110011 01110100 01101001 01101110 01100111 00100000 01100101 01111000 01100101 01110010 01100011 01101001 01110011 01100101 00100001"}' \
    0.0.0.0:8000/hack-defense-system.php
```
