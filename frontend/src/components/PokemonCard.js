import React, { useState } from "react";
import PokemonModal from "./PokemonModal";
import "../styles/global.css";

const PokemonCard = ({ pokemon }) => {
  const [showModal, setShowModal] = useState(false);

  return (
    <>
      <div className="card pokemon-card" onClick={() => setShowModal(true)}>
        <img src={pokemon.image} className="card-img-top" alt={pokemon.name} />
        <div className="card-body text-center">
          <h5 className="card-title">{pokemon.name}</h5>
        </div>
      </div>
      {showModal && <PokemonModal pokemon={pokemon} onClose={() => setShowModal(false)} />}
    </>
  );
};

export default PokemonCard;
