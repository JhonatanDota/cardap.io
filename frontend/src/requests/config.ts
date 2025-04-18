import axios, { AxiosInstance } from "axios";

import applyCaseMiddleware from "axios-case-converter";

const BASE_URL = process.env.REACT_APP_API_BASE_URL ?? "";
const API_TIMEOUT_MILISECONDS = 10000;

console.log(BASE_URL);

export function requester(): AxiosInstance {
  const axiosInstance: AxiosInstance = applyCaseMiddleware(
    axios.create({
      baseURL: BASE_URL,
      headers: {
        "Content-Type": "application/json",
        accept: "application/json",
        "Accept-Language": "pt",
        Authorization: `Bearer `,
      },
      timeout: API_TIMEOUT_MILISECONDS,
    })
  );

  return axiosInstance;
}
