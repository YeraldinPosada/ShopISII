from flask import jsonify, request, current_app
from firebase import db
from functools import wraps

from dotenv import load_dotenv
import os

load_dotenv()

def require_token(f):
    @wraps(f)
    def decorate(*args, **kwargs):
        token = request.headers.get("Authorization")
        if token!= os.getenv("TOKEN"):
            return jsonify({"error": "Usuario no autorizado"})
        return f(*args, **kwargs)
    return decorate


def register_routes(app):
    
    @app.route("/api/productos", methods=['POST'])
    @require_token
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
    @require_token
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
    @require_token
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
    @require_token
    def delete_producto(id):
        db.collection("products").document(id).delete()
        return jsonify({"mensaje": "Producto eliminado"})
    

    @app.route("/api/producto_validar/<id>", methods=['GET'])
    @require_token
    def  validar_producto_stock(id):
        producto = db.collection("products").document(id).get()
        if not producto.exists:
            return  jsonify({"error":"El producto no existe"}), 404
        
        return jsonify({"stock": producto.get("stock")})
    
    @app.route("/api/stock_resta/<id>", methods=['PUT'])
    @require_token
    def restar_stock(id):
        data = request.get_json()
        cantidad = data["cantidad"]

        doc_ref = db.collection("products").document(id)
        producto = doc_ref.get()

        stock_actual = producto.get("stock")
        nuevo_stock = stock_actual - cantidad

        doc_ref.update({"stock": nuevo_stock})

        return jsonify({ "mensaje": "Stock actualizado","stock": nuevo_stock})

    

