import axios, { AxiosRequestConfig } from "axios";

export type Enrolment = {
	firstname: string;
	surname: string;
	ID: number;
	title: string;
	description: string;
	status: "not started" | "in progress" | "completed";
};

export const fetchEnrolments = async (
	params?: {
		page?: number;
		course?: number;
		user?: number;
		search?: string;
	},
	config?: AxiosRequestConfig
) => {
	return axios
		.get<Enrolment[]>("http://localhost:9000/api/enrolment", {
			params,
			...config,
			validateStatus: (status) => 200 <= status && status < 300,
		})
		.then(({ data }) => Promise.resolve(data))
		.catch((error) => Promise.reject(error));
};

export const fetchEnrolmentCount = async (params?: {
	course?: number;
	user?: number;
	search?: string;
}) => {
	return axios
		.get<{ count: number }>("http://localhost:9000/api/enrolment/count", {
			params,
		})
		.then(({ data }) => Promise.resolve(data))
		.catch((error) => Promise.reject(error));
};
