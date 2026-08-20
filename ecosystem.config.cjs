// PM2 config - CHỈ dùng cho môi trường sandbox/preview (PHP built-in server).
// Trên hosting thật: Apache/LiteSpeed + .htaccess đảm nhiệm, KHÔNG cần file này.
module.exports = {
  apps: [
    {
      name: 'sellgame',
      script: 'php',
      args: '-S 0.0.0.0:3000 -t /home/user/webapp /home/user/webapp/router.php',
      cwd: '/home/user/webapp',
      exec_mode: 'fork',
      instances: 1,
      watch: false,
      env: {
        PHP_CLI_SERVER_WORKERS: '4'
      }
    }
  ]
}
