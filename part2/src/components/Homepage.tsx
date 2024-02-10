import React, { useState } from "react";
import { EnrolmentTable } from "./Enrolment";
import { UserDropDown } from "./UserDropDown";
import { Form, InputGroup } from "react-bootstrap";
import { CourseDropDown } from "./CourseDropDown";

function Homepage() {
  const [course, setCourse] = useState<number>();
  const [user, setUser] = useState<number>();
  const [search, setSearch] = useState<string>();

  return (
    <div className="w-75 mx-auto mt-5">
      <h2 className="text-center text-secondary bg-light">
        Enrolment List
      </h2>
      <div className="d-flex w-100 p-3">
        <UserDropDown setValue={setUser} />
        <CourseDropDown setValue={setCourse} />
        <InputGroup className="ml-auto">
          <InputGroup.Text id="search" ><strong>Search: </strong></InputGroup.Text>
          <Form.Control
            placeholder="Press Enter to search..."
            aria-label="search"
            aria-describedby="search"
            onKeyDown={(e) => {
              if (e.code === "Enter") {
                setSearch(e.currentTarget.value);
              }
            }}
          />
        </InputGroup>
      </div>
      <EnrolmentTable course={course} user={user} search={search} />
    </div>
  );
}

export default Homepage;
