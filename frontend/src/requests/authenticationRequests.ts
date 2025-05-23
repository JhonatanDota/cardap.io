import { AxiosResponse } from "axios";

import { requester } from "./config";

import {
  AuthModel,
  RegisterModel,
  SuccessAuthModel,
} from "../models/authenticationModels";

const AUTH: string = "auth";
const REGISTER: string = "register";
const ME: string = "me";
const LOGOUT: string = "logout";

export async function auth(
  data: AuthModel
): Promise<AxiosResponse<SuccessAuthModel>> {
  return await requester().post(AUTH, data);
}

export async function register(data: RegisterModel): Promise<AxiosResponse> {
  return await requester().post(REGISTER, data);
}
