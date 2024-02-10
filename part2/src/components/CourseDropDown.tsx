import React, { useEffect, useState } from "react";
import { Course, fetchCourses } from "../action/course";
import axios from "axios";
import { DropDownSearchBox } from "./DropDownSearchBox";
import { InputGroup } from "react-bootstrap";

export const CourseDropDown = ({
  setValue,
}: {
  setValue: React.Dispatch<React.SetStateAction<number | undefined>>;
}) => {
  const [courses, setCourses] = useState<Course[]>([]);

  useEffect(() => {
    const source = axios.CancelToken.source();

    fetchCourses({ cancelToken: source.token })
      .then((courses) => setCourses(courses))
      .catch((err) => {
        if (!axios.isCancel(err)) console.log(err);
      });

    return () => source.cancel();
  }, []);

  return (
    <InputGroup className="w-50">
      <InputGroup.Text><strong>Course Title: </strong></InputGroup.Text>
      <DropDownSearchBox
        elements={courses}
        filterFunction={(value) => (course) =>
          course.title.includes(value)}
        setElement={(course) => setValue(course.ID)}
        elementToStr={(course) => course.title}
      />
    </InputGroup>
  );
};
