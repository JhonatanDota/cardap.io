import axios, { AxiosResponse } from "axios";

import { requester } from "./config";

import { AuthModel } from "../models/authenticationModels";

const AUTH: string = "auth";
const ME: string = "me";
const LOGOUT: string = "logout";

export async function auth(data: AuthModel): Promise<AxiosResponse<AuthModel>> {
  return await requester().post(AUTH, data);
}
