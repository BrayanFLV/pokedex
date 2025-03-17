import React, { useState, useEffect } from "react";
import { getPokemons, getPokemonById } from "../services/api";
import { FaSearch } from "react-icons/fa";
import PokemonModal from "../components/PokemonModal";
import pokeballImage from "../assets/pokeball.png"; //  Importamos la imagen de la Pokébola lotante
import "../styles/Home.css";

// funcionalidad de la página principal
// Home.js
const Home = () => { 
  const [pokemons, setPokemons] = useState([]);
  const [currentPage, setCurrentPage] = useState(1);
  const [searchTerm, setSearchTerm] = useState("");
  const [selectedPokemon, setSelectedPokemon] = useState(null);
  const [isModalOpen, setIsModalOpen] = useState(false);

  const pokemonsPerPage = 10;
//
  useEffect(() => {
    const fetchData = async () => {
      const data = await getPokemons();
      if (data && data.pokemons) {
        setPokemons(data.pokemons);
      }
    };
    fetchData();
  }, []);

  const filteredPokemons = pokemons.filter((pokemon) =>
    pokemon.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
    pokemon.id.toString() === searchTerm
  );

  const indexOfLastPokemon = currentPage * pokemonsPerPage;
  const indexOfFirstPokemon = indexOfLastPokemon - pokemonsPerPage;
  const currentPokemons = filteredPokemons.slice(indexOfFirstPokemon, indexOfLastPokemon);

  const totalPages = Math.ceil(filteredPokemons.length / pokemonsPerPage);

  const openModal = async (pokemon) => {
    try {
      const pokemonDetails = await getPokemonById(pokemon.id);
      setSelectedPokemon(pokemonDetails);
      setIsModalOpen(true);
    } catch (error) {
      console.error("Error al obtener detalles del Pokémon:", error);
    }
  };

  const closeModal = () => {
    setIsModalOpen(false);
    setSelectedPokemon(null);
  };

  return (
    <div className="background">
      <img src={pokeballImage} alt="Pokébola" className="pokeball left" />
      <img src={pokeballImage} alt="Pokébola" className="pokeball right" />

      <div className="container">
        <h1 className="title">Bienvenido a la Pokédex</h1>

        {/* Barra de búsqueda */}
        <div className="search-container">
          <FaSearch className="search-icon" />
          <input
            type="text"
            placeholder="Buscar Pokémon por nombre o ID"
            className="search-bar"
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
          />
        </div>

        <div className="pokemon-container">
          {currentPokemons.map((pokemon) => (
            <div key={pokemon.id} className="pokemon-card" onClick={() => openModal(pokemon)}>
              {/*  Pokébola en la esquina superior derecha */}
              <img src={pokeballImage} alt="Pokébola" className="pokeball-card" />
              
              {/*  ID del Pokémon */}
              <p className="pokemon-id">#{pokemon.id}</p>

              <img src={pokemon.image} alt={pokemon.name} className="pokemon-image" />
              <p className="pokemon-name">{pokemon.name}</p>
            </div>
          ))}
        </div>

        {/* Paginación */}
        <div className="pagination">
          <button onClick={() => setCurrentPage(currentPage - 1)} disabled={currentPage === 1}>
            ◀ Anterior
          </button>
          <span>Página {currentPage} de {totalPages}</span>
          <button onClick={() => setCurrentPage(currentPage + 1)} disabled={currentPage === totalPages}>
            Siguiente ▶
          </button>
        </div>

        {/* Modal */}
        <PokemonModal isOpen={isModalOpen} onClose={closeModal} pokemon={selectedPokemon} />
      </div>
    </div>
  );
};

export default Home;
