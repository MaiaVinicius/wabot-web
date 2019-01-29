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

        saveExecution(data.pid);

        getKillOrder(function (kill) {
            if (kill) {

                fs.unlink('storage/logs/kill.json', function () {
                    console.log("FORCE_KILL");

                    coffeeProcess.kill(null,'SIGINT');
                });

            }
        });
    });
}

function getKillOrder(cb) {
    fs.readFile('storage/logs/kill.json', function (err, data) {
        if (!err) {
            data = JSON.parse(data);

            if (data.kill) {
                console.log(data.kill)
                cb(true);
            }
        }
    })
}

function saveExecution(pid) {
    var today = new Date();
    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var dateTime = date + ' ' + time;

    var data = {
        datetime: dateTime,
        running: true,
        pid: pid
    };

    fs.writeFile('storage/logs/execution.json', JSON.stringify(data), function (err) {
        if (err) throw err;
        console.log('Execution file saved!');
    });
}

var cron = require('node-cron');
const fs = require("fs");


run();
cron.schedule('*/5 * * * *', () => {
    run()
    // console.log("run")
});