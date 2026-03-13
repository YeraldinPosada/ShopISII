from flask import jsonify, request, current_app
from firebase import db
from functools import wraps

from dotenv import load_dotenv
import os

load_dotenv()

TOKEN_SECRETO = os.getenv("TOKEN_SECRETO")



def register_routes(app):
    @app.route("/api/productos", methods=['POST'])
    def post_productos():
        data = request.get_json()
        product = {
            "name": data["name"],
            "price":data["price"],
            "color":data["color"],
            "stock":data["stock"]
            
        }
        db.collection("products").add(product)
        return jsonify({"mensaje" : "Producto agregado"})
    
    @app.route("/api/productos", methods=['GET'])
    def get_productos():
        products = db.collection("products").stream()
        return jsonify([
    {
        "Nombre": p.get("name"),
        "Price": p.get("price"),
        "Color": p.get("color"),
        "Stock": p.get("stock")
    }
    for p in products
])
    @app.route("/api/productos/<id>", methods=['PUT'])
    def update_producto(id):

        data = request.get_json()

        db.collection("products").document(id).update({
            "name": data["name"],
            "price": data["price"],
            "color": data["color"],
            "stock": data["stock"]
        })

        return jsonify({"mensaje": "Producto actualizado"})

    @app.route("/api/productos/<id>", methods=['DELETE'])
    def delete_producto(id):
        db.collection("products").document(id).delete()
        return jsonify({"mensaje": "Producto eliminado"})

    

