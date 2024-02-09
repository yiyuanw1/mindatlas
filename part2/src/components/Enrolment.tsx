import React from "react";
import { Enrolment } from "../action/enrolment";
import {
  Table,
} from "react-bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";
import ReactPaginate from "react-paginate";

export type EnrolmentItemProps = {
  enrolment: Enrolment;
};

const STATUS_COLOR = {
  "not started": "danger",
  "in progress": "warning",
  completed: "success",
};


export const EnrolmentTable = ({ enrolments }: { enrolments: Enrolment[] }) => {
  return (
    <>
      <Table striped bordered hover >
        <thead>
          <tr>
            <th>#</th>
            <th>User</th>
            <th>Course</th>
            <th>Description</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          {enrolments.map((enrolment, i) => (
            <tr key={i}>
              <td>{enrolment.ID}</td>
              <td>
                {enrolment.firstname} {enrolment.surname}
              </td>
              <td>{enrolment.title}</td>
              <td>{enrolment.description}</td>
              <td>
                <span
                  className={`text-${STATUS_COLOR[enrolment.status]
                    }`}
                >
                  {enrolment.status
                    .split(" ")
                    .map(
                      (w) =>
                        w[0].toUpperCase() + w.slice(1)
                    )
                    .join(" ")}
                </span>
              </td>
            </tr>
          ))}
        </tbody>
      </Table>
    </>
  );
};
