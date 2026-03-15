const mongoose = require("mongoose")

const VentaSchema = new mongoose.Schema({
    producto_id: String,
    cantidad: Number,
    usuario_id:Number,
    total: Number
})

module.exports = mongoose.model("Venta", VentaSchema)