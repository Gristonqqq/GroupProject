const express = require('express')
const app = express()
const path = require('path')


app.get('/', (req, res) => {
    res.send('Main page')
})
app.get('/audio/audioFiles.json', (req, res) => {
    res.sendFile(path.join(__dirname, 'audio', 'audioFiles.json'))
})

app.get('/audio/:filename', (req, res) => {
    let filename = req.params.filename
    res.sendFile(path.join(__dirname, 'audio', filename))
})

app.listen(3000, () => {
    console.log('Server started on port 3000')
})