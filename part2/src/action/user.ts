import axios, { AxiosRequestConfig } from "axios";

export type User = {
	ID: number;
	firstname: string;
	surname: string;
};

export const fetchUsers = async (config?: AxiosRequestConfig) => {
	return axios
		.get<User[]>(`${process.env.REACT_APP_API_URL}/user`, { ...config })
		.then(({ data }) => Promise.resolve(data))
		.catch((err) => Promise.reject(err));
};
