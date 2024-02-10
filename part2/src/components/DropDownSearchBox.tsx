import React, { useEffect, useState } from "react";
import { Dropdown, Form } from "react-bootstrap";

export const DropDownSearchBox = <T extends unknown>({
	setElement,
	elements,
	filterFunction,
	elementToStr,
}: {
	elements: T[];
	filterFunction: (value: string) => (elem: T) => boolean;
	setElement: (elem: T) => void;
	elementToStr: (elem: T) => string;
}) => {
	const [filteredElements, setFilteredElements] = useState<T[]>([]);
	const [textInput, setTextInput] = useState("");

	useEffect(() => {
		setFilteredElements(elements);
	}, [elements]);

	const onTextInputChange: React.ChangeEventHandler<HTMLButtonElement> = (
		e
	) => {
		e.preventDefault();
		setTextInput(e.currentTarget.value);
		setFilteredElements(elements.filter(filterFunction(e.currentTarget.value)));
	};

	return (
		<Dropdown className="ml-3">
			<Dropdown.Toggle
				as={Form.Control}
				onChange={onTextInputChange}
				value={textInput}
			>
				{/* <Form.Control onChange={onTextInputChange} /> */}
			</Dropdown.Toggle>
			<Dropdown.Menu>
				{filteredElements.map((element, i) => (
					<Dropdown.Item
						key={i}
						onClick={(e) => {
							setElement(element);
							setTextInput(e.currentTarget.innerText);
						}}
					>
						{elementToStr(element)}
					</Dropdown.Item>
				))}
			</Dropdown.Menu>
		</Dropdown>
	);
};
