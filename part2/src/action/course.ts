import axios, { AxiosRequestConfig } from "axios";

export type Course = {
	ID: number;
	title: string;
	description: string;
};

export const fetchCourses = async (config?: AxiosRequestConfig) => {
	return axios
		.get<Course[]>(`${process.env.REACT_APP_API_URL!}/course`, { ...config })
		.then(({ data }) => Promise.resolve(data))
		.catch((err) => Promise.reject(err));
};
