const express = require("express")
const router = express.Router()
const Venta = require("./models")


require('dotenv').config();

const TOKEN_SECRETO = process.env.TOKEN_SECRETO;

function requireToken(req, res, next) {
    const token = req.headers["Authorization"];
    if (token !== `${TOKEN_SECRETO}`) {
        return res.status(403).json({ error: "No autorizado" });
    }
    next();
}


router.post("/" , requireToken, async (req, res) => {

    const venta = new Venta(req.body)
    await venta.save()
    res.json({
        mensaje: "Venta creada",
        venta
    })
})

router.get("/" , requireToken, async (req, res) => {

    const ventas = await Venta.find()

    res.json(ventas)
})


router.get("/:id" , requireToken, async (req, res) => {

    const venta = await Venta.findById(req.params.id)

    res.json(venta)
})


router.put("/:id" , requireToken, async (req, res) => {

    const venta = await Venta.findByIdAndUpdate(
        req.params.id,
        req.body,
        { new: true }
    )
    res.json(venta)
})


router.delete("/:id" , requireToken, async (req, res) => {

    await Venta.findByIdAndDelete(req.params.id)

    res.json({
        mensaje: "Venta eliminada"
    })
})

router.post("/usuario" , requireToken, async (req, res) => {
    const usuario_id = req.body.usuario_id;

    const ventas_usuario = await Venta.find({
        usuario_id: usuario_id
    });

    res.json(ventas_usuario);
})

module.exports = router