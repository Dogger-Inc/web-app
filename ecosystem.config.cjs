module.exports = {
    apps: [
        {
            name: 'dooger-ssr-server',
            exec_mode: 'cluster',
            instances: 'max',
            restart: 'always',
            script: 'bootstrap/ssr/ssr.js',
        }
    ]
}