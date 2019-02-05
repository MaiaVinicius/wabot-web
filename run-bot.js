var exec = require('child_process').exec;

function run() {

    var coffeeProcess = exec('go run main.go', {
        cwd: '/Users/maiavinicius/go/src/github.com/MaiaVinicius/wabot'
    });

    coffeeProcess.stderr.on('data', function (data) {
        console.log('stderr: ' + data.toString());

        getKillOrder(function (kill) {
            if (kill) {

                fs.unlink('storage/logs/kill.json', function () {
                    console.log("FORCE_KILL");

                    coffeeProcess.kill(null, 'SIGINT');
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


saveExecution()

setInterval(function () {
    saveExecution()
}, 25000);

run();

cron.schedule('*/12 * * * *', () => {
    run()
    // console.log("run")
});