cmake_minimum_required(VERSION 3.1)
set(PROJECT_NAME stemka)
project(${PROJECT_NAME})

set(CMAKE_C_STANDARD 11)
set(CMAKE_CXX_STANDARD 14)

option(BUILD_CONVERTER "Enabling converter build." OFF)
option(BUILD_EXAMPLE "Enabling example build." OFF)
option(BUILD_DEV "Enabling dev build." OFF)

# Include dependencies.
include_directories(${CMAKE_SOURCE_DIR})
# Collecting a list of sources.
file(GLOB_RECURSE SOURCE_FILES library/*.[hc]pp library/*.c)
file(GLOB_RECURSE INCLUDE_FILES include/*.h)

add_library(${PROJECT_NAME} ${SOURCE_FILES})

if (BUILD_CONVERTER)
    add_subdirectory(convert)
endif (BUILD_CONVERTER)

if (BUILD_EXAMPLE)
    add_subdirectory(example)
endif (BUILD_EXAMPLE)

if (BUILD_DEV)
    add_subdirectory(dev/cz)
endif (BUILD_DEV)

install(FILES ${INCLUDE_FILES} DESTINATION /usr/local/include/stemka)
install(TARGETS ${PROJECT_NAME} DESTINATION /usr/local/lib)
