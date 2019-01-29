var exec = require('child_process').exec;

function run() {

    var coffeeProcess = exec('go run main.go', {
        cwd: '/Users/maiavinicius/go/src/github.com/MaiaVinicius/wabot'
    });


    coffeeProcess.stdout.on('data', function (data) {
        console.log(data);
    });

    coffeeProcess.stdout.on('data', function (data) {
        console.log(data);
    });


    coffeeProcess.on('exit', function (code) {
        console.log('child process exited with code ' + code.toString());
    });

    coffeeProcess.stderr.on('data', function (data) {
        console.log('stderr: ' + data.toString());
    });

}

var cron = require('node-cron');


run();
cron.schedule('*/1 * * * *', () => {
    run()
});