import axios from "axios";

const API_BASE_URL = "https://pokedex-production-3a1b.up.railway.app"; // Nueva URL en Railway
 // URL del backend

export const getPokemons = async (page = 1) => {
  try {
    const response = await axios.get(`${API_BASE_URL}/pokemon?page=${page}`);
    return response.data;
  } catch (error) {
    console.error("Error al obtener los Pokémon:", error);
    return null;
  }
};

export const getPokemonById = async (id) => {
  try {
    const response = await axios.get(`${API_BASE_URL}/pokemon/${id}`);
    
    return {
      id: response.data.id,
      name: response.data.name,
      types: response.data.types || [],
      abilities: response.data.abilities || [],
      image: response.data.sprite_url || `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/${id}.png`, // ✅ Agregamos una imagen por defecto
    };
  } catch (error) {
    console.error(`Error al obtener el Pokémon con ID ${id}:`, error);
    return null;
  }
};

