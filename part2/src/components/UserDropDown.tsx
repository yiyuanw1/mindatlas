import React, { useEffect, useState } from "react";
import { User, fetchUsers } from "../action/user";
import axios from "axios";
import { DropDownSearchBox } from "./DropDownSearchBox";
import { InputGroup } from "react-bootstrap";

export const UserDropDown = ({
	setValue,
}: {
	setValue: React.Dispatch<React.SetStateAction<number | undefined>>;
}) => {
	const [users, setUsers] = useState<User[]>([]);

	useEffect(() => {
		const source = axios.CancelToken.source();

		fetchUsers({ cancelToken: source.token })
			.then((users) => setUsers(users))
			.catch((err) => {
				if (!axios.isCancel(err)) console.log(err);
			});

		return () => source.cancel();
	}, []);

	return (
		<InputGroup className="w-50">
			<InputGroup.Text><strong>User: </strong></InputGroup.Text>
			<DropDownSearchBox
				elements={users}
				setElement={(user) => setValue(user.ID)}
				filterFunction={(value) => (user) =>
					user.firstname.includes(value) ||
					user.surname.includes(value)}
				elementToStr={(user) => `${user.firstname} ${user.surname}`}
			/>
		</InputGroup>
	);
};
