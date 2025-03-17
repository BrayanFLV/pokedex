import React from "react";
import "../styles/Home.css";

const PokemonModal = ({ isOpen, onClose, pokemon }) => {
  if (!isOpen || !pokemon) return null;

  return (
    <div className="modal-overlay" onClick={onClose}>
      <div className="modal-content" onClick={(e) => e.stopPropagation()}>
        <button className="close-button" onClick={onClose}>✖</button>
        <h2 className="modal-title">{pokemon.name}</h2>

        {/*Corrección: Verificamos que la imagen exista */}
        {pokemon.image ? (
          <img className="modal-image" src={pokemon.image} alt={pokemon.name} /> /* traer imagen */
        ) : (
          <p className="no-image">No hay imagen disponible</p>
        )}

        <p><strong>ID:</strong> {pokemon.id}</p>
        <p><strong>Tipo:</strong> {pokemon.types?.join(", ") || "Desconocido"}</p>
        <p><strong>Habilidades:</strong> {pokemon.abilities?.join(", ") || "Desconocidas"}</p>
      </div>
    </div>
  );
};

export default PokemonModal;
