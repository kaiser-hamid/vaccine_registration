import axios from "axios";
import data from "./config/data";

const headers = {
  "Content-Type": "application/json",
};

const http = axios.create({
  baseURL: data.api_url,
  headers,
});

export default http;
