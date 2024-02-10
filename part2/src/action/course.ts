import axios, { AxiosRequestConfig } from "axios";

export type Course = {
	ID: number;
	title: string;
	description: string;
};

export const fetchCourses = async (config?: AxiosRequestConfig) => {
	return axios
		.get<Course[]>("http://localhost:9000/api/course", { ...config })
		.then(({ data }) => Promise.resolve(data))
		.catch((err) => Promise.reject(err));
};
