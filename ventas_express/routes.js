const express = require("express")
const router = express.Router()
const Venta = require("./models")


router.post("/", async (req, res) => {

    const venta = new Venta(req.body)
    await venta.save()
    res.json({
        mensaje: "Venta creada",
        venta
    })
})

router.get("/", async (req, res) => {

    const ventas = await Venta.find()

    res.json(ventas)
})


router.get("/:id", async (req, res) => {

    const venta = await Venta.findById(req.params.id)

    res.json(venta)
})


router.put("/:id", async (req, res) => {

    const venta = await Venta.findByIdAndUpdate(
        req.params.id,
        req.body,
        { new: true }
    )
    res.json(venta)
})


router.delete("/:id", async (req, res) => {

    await Venta.findByIdAndDelete(req.params.id)

    res.json({
        mensaje: "Venta eliminada"
    })
})

router.post("/usuario", async (req, res) => {
    const usuario_id = req.body.usuario_id;

    const ventas_usuario = await Venta.find({
        usuario_id: usuario_id
    });

    res.json(ventas_usuario);
})

module.exports = router