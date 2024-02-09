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
		filter?: {
			course?: number;
			user?: number;
		};
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
