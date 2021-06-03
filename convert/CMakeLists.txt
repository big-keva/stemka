cmake_minimum_required(VERSION 3.1)
set(PROJECT_NAME genmorph)
project(${PROJECT_NAME})

set(PROJECT_LIBS stemka)
# Collecting a list of sources.
file(GLOB_RECURSE SOURCE_FILES *.[hc]pp)

add_executable(${PROJECT_NAME} ${SOURCE_FILES})
target_link_libraries(
    ${PROJECT_NAME}
    ${PROJECT_LIBS}
)
